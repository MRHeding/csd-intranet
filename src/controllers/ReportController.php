<?php
require_once 'models/Report.php';
require_once 'middleware/AuthMiddleware.php';

class ReportController {
    private $reportModel;
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->reportModel = new Report($pdo);
    }

    public function index() {
        // Only Admin and HR can access reports
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $reports = $this->reportModel->getAllReports();
        include 'views/reports/index.php';
    }

    public function create() {
        // Only Admin and HR can create reports
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $createdBy = AuthMiddleware::getCurrentUserId();

            if ($this->reportModel->createReport($title, $content, $createdBy)) {
                $message = 'Report created successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to create report.';
                $messageType = 'error';
            }
        }
        
        include 'views/reports/create.php';
    }
    
    public function view() {
        // Only Admin and HR can view reports
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: ?controller=Report&action=index');
            exit;
        }
        
        $report = $this->reportModel->getReportById($id);
        if (!$report) {
            header('Location: ?controller=Report&action=index');
            exit;
        }
        
        include 'views/reports/view.php';
    }
    
    public function edit() {
        // Only Admin and HR can edit reports
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $id = $_GET['id'] ?? null;
        $message = '';
        $messageType = '';
        
        if (!$id) {
            header('Location: ?controller=Report&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            
            if ($this->reportModel->updateReport($id, $title, $content)) {
                $message = 'Report updated successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to update report.';
                $messageType = 'error';
            }
        }
        
        $report = $this->reportModel->getReportById($id);
        if (!$report) {
            header('Location: ?controller=Report&action=index');
            exit;
        }
        
        include 'views/reports/edit.php';
    }
    
    public function delete() {
        // Only Admin and HR can delete reports
        AuthMiddleware::requireRole(['admin', 'hr']);
        
        $id = $_GET['id'] ?? null;
        
        if ($id && $this->reportModel->deleteReport($id)) {
            header('Location: ?controller=Report&action=index&message=deleted');
        } else {
            header('Location: ?controller=Report&action=index&error=delete_failed');
        }
        exit;
    }
    
    public function generateAttendanceReport() {
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');
        
        $attendanceData = $this->reportModel->getAttendanceReportData($startDate, $endDate);
        
        include 'views/reports/attendance_report.php';
    }
}