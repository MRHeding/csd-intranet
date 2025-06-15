<?php

class Report {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllReports() {
        $query = "SELECT * FROM reports ORDER BY created_at DESC";
        
        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function createReport($title, $content, $createdBy = null) {
        $query = "INSERT INTO reports (title, content, created_by) VALUES (?, ?, ?)";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$title, $content, $createdBy]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateReport($id, $title, $content) {
        $query = "UPDATE reports SET title = ?, content = ? WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$title, $content, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteReport($id) {
        $query = "DELETE FROM reports WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getReportById($id) {
        $query = "SELECT * FROM reports WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAttendanceReportData($startDate, $endDate) {
        $query = "SELECT 
                    u.username,
                    u.email,
                    COUNT(CASE WHEN a.status = 'present' THEN 1 END) as present_days,
                    COUNT(CASE WHEN a.status = 'absent' THEN 1 END) as absent_days,
                    COUNT(CASE WHEN a.status = 'leave' THEN 1 END) as leave_days,
                    COUNT(*) as total_days
                  FROM users u
                  LEFT JOIN attendance a ON u.id = a.user_id 
                    AND a.date BETWEEN ? AND ?
                  GROUP BY u.id, u.username, u.email
                  ORDER BY u.username";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$startDate, $endDate]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAttendanceStats($startDate, $endDate) {
        $query = "SELECT 
                    DATE(a.date) as attendance_date,
                    COUNT(CASE WHEN a.status = 'present' THEN 1 END) as present_count,
                    COUNT(CASE WHEN a.status = 'absent' THEN 1 END) as absent_count,
                    COUNT(CASE WHEN a.status = 'leave' THEN 1 END) as leave_count,
                    COUNT(*) as total_records
                  FROM attendance a
                  WHERE a.date BETWEEN ? AND ?
                  GROUP BY DATE(a.date)
                  ORDER BY attendance_date DESC";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$startDate, $endDate]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}