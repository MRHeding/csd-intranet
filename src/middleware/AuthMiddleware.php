<?php

class AuthMiddleware {
    
    public static function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?controller=Auth&action=login');
            exit;
        }
    }
    
    public static function requireRole($requiredRoles) {
        self::requireLogin();
        
        if (!is_array($requiredRoles)) {
            $requiredRoles = [$requiredRoles];
        }
        
        $userRole = $_SESSION['role'] ?? null;
        
        if (!in_array($userRole, $requiredRoles)) {
            http_response_code(403);
            include 'views/errors/403.php';
            exit;
        }
    }
    
    public static function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    public static function isHR() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'hr';
    }
    
    public static function isEmployee() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'employee';
    }
    
    public static function canManageAttendance() {
        return self::isAdmin() || self::isHR();
    }
    
    public static function canManageEvents() {
        return self::isAdmin() || self::isHR();
    }
    
    public static function canManageReports() {
        return self::isAdmin() || self::isHR();
    }
    
    public static function canViewOthersAttendance() {
        return self::isAdmin() || self::isHR();
    }
    
    public static function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }
      public static function getCurrentUserRole() {
        return $_SESSION['role'] ?? null;
    }
    
    public static function canEditAttendance($attendanceUserId) {
        if (self::canManageAttendance()) {
            return true; // Admin and HR can edit any record
        }
        
        // Employees can edit their own records
        return self::getCurrentUserId() == $attendanceUserId;
    }
    
    public static function hasAccess($resource, $action = 'view') {
        $role = self::getCurrentUserRole();
        
        $permissions = [
            'admin' => [
                'attendance' => ['view', 'create', 'edit', 'delete'],
                'events' => ['view', 'create', 'edit', 'delete'],
                'reports' => ['view', 'create', 'edit', 'delete'],
                'users' => ['view', 'create', 'edit', 'delete'],
                'dashboard' => ['view']
            ],
            'hr' => [
                'attendance' => ['view', 'create', 'edit', 'delete'],
                'events' => ['view', 'create', 'edit', 'delete'],
                'reports' => ['view', 'create', 'edit', 'delete'],
                'dashboard' => ['view']
            ],
            'employee' => [
                'attendance' => ['view', 'create'], // Can view own and create own
                'events' => ['view'],
                'dashboard' => ['view']
            ]
        ];
        
        return isset($permissions[$role][$resource]) && 
               in_array($action, $permissions[$role][$resource]);
    }
}
