<?php

class Event {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEvents() {
        $query = "SELECT * FROM events ORDER BY event_date ASC";
        
        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function createEvent($title, $description, $eventDate, $createdBy = null) {
        $query = "INSERT INTO events (title, description, event_date, created_by) VALUES (?, ?, ?, ?)";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$title, $description, $eventDate, $createdBy]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateEvent($id, $title, $description, $eventDate) {
        $query = "UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$title, $description, $eventDate, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteEvent($id) {
        $query = "DELETE FROM events WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getEventById($id) {
        $query = "SELECT * FROM events WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getUpcomingEvents($limit = 5) {
        $query = "SELECT * FROM events WHERE event_date >= NOW() ORDER BY event_date ASC LIMIT ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getPastEvents($limit = 10) {
        $query = "SELECT * FROM events WHERE event_date < NOW() ORDER BY event_date DESC LIMIT ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}