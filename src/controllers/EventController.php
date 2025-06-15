<?php
require_once 'models/Event.php';
require_once 'middleware/AuthMiddleware.php';

class EventController {
    private $eventModel;
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->eventModel = new Event($pdo);
    }

    public function index() {
        AuthMiddleware::requireLogin();
        
        $events = $this->eventModel->getAllEvents();
        include 'views/events/index.php';
    }

    public function create() {
        // Only Admin and HR can create events
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $eventDate = $_POST['event_date'];
            $createdBy = AuthMiddleware::getCurrentUserId();

            if ($this->eventModel->createEvent($title, $description, $eventDate, $createdBy)) {
                $message = 'Event created successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to create event.';
                $messageType = 'error';
            }
        }
        
        include 'views/events/create.php';
    }
    
    public function edit() {
        // Only Admin and HR can edit events
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $id = $_GET['id'] ?? null;
        $message = '';
        $messageType = '';
        
        if (!$id) {
            header('Location: ?controller=Event&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $eventDate = $_POST['event_date'];
            
            if ($this->eventModel->updateEvent($id, $title, $description, $eventDate)) {
                $message = 'Event updated successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to update event.';
                $messageType = 'error';
            }
        }
        
        $event = $this->eventModel->getEventById($id);
        if (!$event) {
            header('Location: ?controller=Event&action=index');
            exit;
        }
        
        include 'views/events/edit.php';
    }
    
    public function delete() {
        // Only Admin and HR can delete events
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $id = $_GET['id'] ?? null;
        
        if ($id && $this->eventModel->deleteEvent($id)) {
            header('Location: ?controller=Event&action=index&message=deleted');
        } else {
            header('Location: ?controller=Event&action=index&error=delete_failed');
        }
        exit;
    }
}