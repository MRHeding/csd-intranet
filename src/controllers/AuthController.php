<?php
require_once 'models/User.php';

class AuthController {
    private $userModel;
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }

    public function login() {
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->authenticate($username, $password);
              if ($user) {
                session_start();                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                header('Location: ?controller=Dashboard&action=dashboard');
                exit;
            } else {
                $message = 'Invalid username or password.';
                $messageType = 'error';
            }
        }
        
        include 'views/auth/login.php';
    }
    
    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?controller=Auth&action=login');
        exit;
    }
      public function register() {
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $fullName = $_POST['full_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validation
            if (empty($fullName)) {
                $message = 'Full name is required.';
                $messageType = 'error';
            } elseif ($password !== $confirmPassword) {
                $message = 'Passwords do not match.';
                $messageType = 'error';
            } elseif (strlen($password) < 6) {
                $message = 'Password must be at least 6 characters long.';
                $messageType = 'error';
            } elseif ($this->userModel->userExists($username, $email)) {
                $message = 'Username or email already exists.';
                $messageType = 'error';
            } else {
                if ($this->userModel->createUser($username, $fullName, $email, $password)) {
                    $message = 'Account created successfully! You can now login.';
                    $messageType = 'success';
                } else {
                    $message = 'Failed to create account. Please try again.';
                    $messageType = 'error';
                }
            }
        }
        
        include 'views/auth/register.php';
    }
}
