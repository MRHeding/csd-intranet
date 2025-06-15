<?php
require_once 'models/Attendance.php';
require_once 'middleware/AuthMiddleware.php';

class AttendanceController {
    private $attendanceModel;
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->attendanceModel = new Attendance($pdo);
    }

    public function index() {
        AuthMiddleware::requireLogin();
        
        // If regular employee, show only their own attendance
        if (AuthMiddleware::isEmployee()) {
            $attendanceRecords = $this->attendanceModel->getAttendanceByUserId(AuthMiddleware::getCurrentUserId());
        } else {
            // Admin and HR can see all attendance
            $attendanceRecords = $this->attendanceModel->getAllAttendance();
        }
        
        include 'views/attendance/index.php';
    }

    public function create() {
        // Only Admin and HR can create attendance for others
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_POST['user_id'];
            $date = $_POST['date'];
            $status = $_POST['status'];
            $createdBy = AuthMiddleware::getCurrentUserId();

            if ($this->attendanceModel->createAttendance($userId, $date, $status, $createdBy)) {
                $message = 'Attendance recorded successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to record attendance. Attendance may already exist for this date.';
                $messageType = 'error';
            }
        }
        
        // Get all users for the dropdown
        $users = $this->attendanceModel->getAllUsers();
        include 'views/attendance/create.php';
    }
    
    public function edit() {
        AuthMiddleware::requireLogin();
        
        $id = $_GET['id'] ?? null;
        $message = '';
        $messageType = '';
        
        if (!$id) {
            header('Location: ?controller=Attendance&action=index');
            exit;
        }
        
        // Get attendance record first to check permissions
        $attendance = $this->attendanceModel->getAttendanceById($id);
        if (!$attendance) {
            header('Location: ?controller=Attendance&action=index');
            exit;
        }
        
        // Check if user can edit this record
        $canEdit = false;
        if (AuthMiddleware::canManageAttendance()) {
            $canEdit = true; // Admin and HR can edit any record
        } elseif (AuthMiddleware::isEmployee() && $attendance['user_id'] == AuthMiddleware::getCurrentUserId()) {
            $canEdit = true; // Employees can edit their own records
        }
        
        if (!$canEdit) {
            AuthMiddleware::requireRole(['admin', 'hr']); // This will show 403 error
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status'];
            
            if ($this->attendanceModel->updateAttendance($id, $status)) {
                $message = 'Attendance updated successfully!';
                $messageType = 'success';
                // Refresh attendance data
                $attendance = $this->attendanceModel->getAttendanceById($id);
            } else {
                $message = 'Failed to update attendance.';
                $messageType = 'error';
            }
        }
        
        include 'views/attendance/edit.php';
    }
    
    public function delete() {
        // Only Admin and HR can delete attendance records
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $id = $_GET['id'] ?? null;
        
        if ($id && $this->attendanceModel->deleteAttendance($id)) {
            header('Location: ?controller=Attendance&action=index&message=deleted');
        } else {
            header('Location: ?controller=Attendance&action=index&error=delete_failed');
        }
        exit;
    }
    
    public function markOwn() {
        // Employees can mark their own attendance
        AuthMiddleware::requireLogin();
        
        $message = '';
        $messageType = '';
        $currentUserId = AuthMiddleware::getCurrentUserId();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_POST['date'];
            $status = $_POST['status'];

            if ($this->attendanceModel->createAttendance($currentUserId, $date, $status, $currentUserId)) {
                $message = 'Your attendance has been recorded successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to record attendance. You may have already marked attendance for this date.';
                $messageType = 'error';
            }
        }
        
        include 'views/attendance/mark_own.php';
    }
}