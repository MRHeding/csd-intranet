<?php

class Attendance {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllAttendance() {
        $query = "SELECT a.*, u.username, u.full_name, u.email 
                  FROM attendance a 
                  LEFT JOIN users u ON a.user_id = u.id 
                  ORDER BY a.date DESC, u.full_name ASC";
        
        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAttendanceByUserId($userId) {
        $query = "SELECT a.*, u.username, u.full_name, u.email 
                  FROM attendance a 
                  LEFT JOIN users u ON a.user_id = u.id 
                  WHERE a.user_id = ?
                  ORDER BY a.date DESC";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function createAttendance($userId, $date, $status, $createdBy = null) {
        // Check if attendance already exists for this user and date
        $checkQuery = "SELECT id FROM attendance WHERE user_id = ? AND date = ?";
        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->execute([$userId, $date]);
        
        if ($checkStmt->rowCount() > 0) {
            return false; // Attendance already exists
        }

        $query = "INSERT INTO attendance (user_id, date, status, created_by) VALUES (?, ?, ?, ?)";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$userId, $date, $status, $createdBy]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateAttendance($id, $status) {
        $query = "UPDATE attendance SET status = ? WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$status, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteAttendance($id) {
        $query = "DELETE FROM attendance WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAttendanceById($id) {
        $query = "SELECT a.*, u.username, u.email 
                  FROM attendance a 
                  LEFT JOIN users u ON a.user_id = u.id 
                  WHERE a.id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllUsers() {
        $query = "SELECT id, username, full_name, email FROM users ORDER BY full_name ASC";
        
        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAttendanceByDateRange($startDate, $endDate) {
        $query = "SELECT a.*, u.username, u.full_name, u.email 
                  FROM attendance a 
                  LEFT JOIN users u ON a.user_id = u.id 
                  WHERE a.date BETWEEN ? AND ? 
                  ORDER BY a.date DESC, u.full_name ASC";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$startDate, $endDate]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAttendanceStats() {
        $query = "SELECT 
                    status,
                    COUNT(*) as count,
                    DATE(date) as attendance_date
                  FROM attendance 
                  WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                  GROUP BY status, DATE(date)
                  ORDER BY attendance_date DESC";
        
        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}