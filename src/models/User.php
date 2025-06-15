<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function authenticate($username, $password) {
        $query = "SELECT id, username, full_name, email, role, created_at FROM users WHERE username = ? OR email = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get password separately for verification
            $passwordQuery = "SELECT password FROM users WHERE username = ? OR email = ?";
            $passwordStmt = $this->pdo->prepare($passwordQuery);
            $passwordStmt->execute([$username, $username]);
            $passwordData = $passwordStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && $passwordData && password_verify($password, $passwordData['password'])) {
                return $user;
            }
            
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function createUser($username, $fullName, $email, $password, $role = 'employee') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, full_name, email, password, role) VALUES (?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$username, $fullName, $email, $hashedPassword, $role]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function userExists($username, $email) {
        $query = "SELECT id FROM users WHERE username = ? OR email = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$username, $email]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return true; // Assume exists to be safe
        }
    }

    public function getUserById($id) {
        $query = "SELECT id, username, full_name, email, role, created_at FROM users WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllUsers() {
        $query = "SELECT id, username, full_name, email, role, created_at FROM users ORDER BY full_name ASC";
        
        try {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function updateUser($id, $username, $email) {
        $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$username, $email, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}