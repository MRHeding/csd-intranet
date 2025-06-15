<?php

class DashboardController {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    public function dashboard() {
        // Get role-specific stats for the dashboard
        $stats = $this->getDashboardStats();
        $recentActivity = $this->getRecentActivity();
        $quickStats = $this->getQuickStats();
        
        // Load the dashboard view
        include_once 'views/dashboard.php';
    }
    
    private function getDashboardStats() {
        $stats = [];
        $currentUserId = $_SESSION['user_id'];
        $userRole = $_SESSION['role'];
        
        try {
            if ($userRole === 'employee') {
                // Employee-specific stats (personal data)
                $stats['my_attendance_this_month'] = $this->getMyAttendanceThisMonth($currentUserId);
                $stats['my_attendance_percentage'] = $this->getMyAttendancePercentage($currentUserId);
                $stats['upcoming_events'] = $this->getUpcomingEventsCount();
                $stats['my_recent_attendance'] = $this->getMyRecentAttendance($currentUserId);
            } else {
                // Admin/HR stats (organizational data)
                $stmt = $this->pdo->query("SELECT COUNT(*) as total_users FROM users");
                $stats['total_users'] = $stmt->fetchColumn();
                
                $stmt = $this->pdo->query("SELECT COUNT(*) as today_attendance FROM attendance WHERE date = CURDATE()");
                $stats['today_attendance'] = $stmt->fetchColumn();
                
                $stmt = $this->pdo->query("SELECT COUNT(*) as upcoming_events FROM events WHERE event_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)");
                $stats['upcoming_events'] = $stmt->fetchColumn();
                
                $stmt = $this->pdo->query("SELECT COUNT(*) as total_reports FROM reports");
                $stats['total_reports'] = $stmt->fetchColumn();
            }
            
        } catch (PDOException $e) {
            // If tables don't exist yet, set default values
            if ($userRole === 'employee') {
                $stats = [
                    'my_attendance_this_month' => 0,
                    'my_attendance_percentage' => 0,
                    'upcoming_events' => 0,
                    'my_recent_attendance' => []
                ];
            } else {
                $stats = [
                    'total_users' => 0,
                    'today_attendance' => 0,
                    'upcoming_events' => 0,
                    'total_reports' => 0
                ];
            }
        }
        
        return $stats;
    }
    
    private function getRecentActivity() {
        $userRole = $_SESSION['role'];
        $currentUserId = $_SESSION['user_id'];
        $activities = [];
        
        try {
            if ($userRole === 'employee') {
                // Employee sees their own recent activities
                $stmt = $this->pdo->prepare("
                    SELECT 'attendance' as type, date as activity_date, status as description 
                    FROM attendance 
                    WHERE user_id = ? 
                    ORDER BY date DESC 
                    LIMIT 5
                ");
                $stmt->execute([$currentUserId]);
                $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Admin/HR sees system-wide recent activities
                $stmt = $this->pdo->query("
                    SELECT 
                        'attendance' as type, 
                        a.date as activity_date, 
                        CONCAT(u.username, ' marked ', a.status) as description 
                    FROM attendance a 
                    JOIN users u ON a.user_id = u.id 
                    ORDER BY a.date DESC, a.created_at DESC 
                    LIMIT 10
                ");
                $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $activities = [];
        }
        
        return $activities;
    }
    
    private function getQuickStats() {
        $userRole = $_SESSION['role'];
        $currentUserId = $_SESSION['user_id'];
        $quickStats = [];
        
        try {
            if ($userRole === 'employee') {
                // Employee quick stats
                $quickStats = [
                    'days_worked_this_month' => $this->getMyAttendanceThisMonth($currentUserId),
                    'next_event' => $this->getNextEvent(),
                    'attendance_streak' => $this->getAttendanceStreak($currentUserId)
                ];
            } else {
                // Admin/HR quick stats
                $stmt = $this->pdo->query("
                    SELECT 
                        COUNT(CASE WHEN status = 'present' THEN 1 END) as present_today,
                        COUNT(CASE WHEN status = 'absent' THEN 1 END) as absent_today,
                        COUNT(CASE WHEN status = 'leave' THEN 1 END) as on_leave_today
                    FROM attendance 
                    WHERE date = CURDATE()
                ");
                $todayStats = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $quickStats = [
                    'present_today' => $todayStats['present_today'] ?? 0,
                    'absent_today' => $todayStats['absent_today'] ?? 0,
                    'on_leave_today' => $todayStats['on_leave_today'] ?? 0,
                    'attendance_rate' => $this->getAttendanceRate()
                ];
            }
        } catch (PDOException $e) {
            $quickStats = [];
        }
        
        return $quickStats;
    }
    
    private function getMyAttendanceThisMonth($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM attendance 
                WHERE user_id = ? 
                AND YEAR(date) = YEAR(CURDATE()) 
                AND MONTH(date) = MONTH(CURDATE())
                AND status = 'present'
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    private function getMyAttendancePercentage($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*) as percentage
                FROM attendance 
                WHERE user_id = ? 
                AND YEAR(date) = YEAR(CURDATE()) 
                AND MONTH(date) = MONTH(CURDATE())
            ");
            $stmt->execute([$userId]);
            $result = $stmt->fetchColumn();
            return round($result, 1);
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    private function getUpcomingEventsCount() {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM events WHERE event_date >= CURDATE()");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    private function getMyRecentAttendance($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT date, status 
                FROM attendance 
                WHERE user_id = ? 
                ORDER BY date DESC 
                LIMIT 7
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    private function getNextEvent() {
        try {
            $stmt = $this->pdo->query("
                SELECT title, event_date, description 
                FROM events 
                WHERE event_date >= CURDATE() 
                ORDER BY event_date ASC 
                LIMIT 1
            ");
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    
    private function getAttendanceStreak($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT date, status 
                FROM attendance 
                WHERE user_id = ? 
                AND date <= CURDATE() 
                ORDER BY date DESC 
                LIMIT 30
            ");
            $stmt->execute([$userId]);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $streak = 0;
            foreach ($records as $record) {
                if ($record['status'] === 'present') {
                    $streak++;
                } else {
                    break;
                }
            }
            return $streak;
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    private function getAttendanceRate() {
        try {
            $stmt = $this->pdo->query("
                SELECT 
                    COUNT(CASE WHEN status = 'present' THEN 1 END) * 100.0 / COUNT(*) as rate
                FROM attendance 
                WHERE YEAR(date) = YEAR(CURDATE()) 
                AND MONTH(date) = MONTH(CURDATE())
            ");
            $result = $stmt->fetchColumn();
            return round($result, 1);
        } catch (PDOException $e) {
            return 0;
        }
    }
}