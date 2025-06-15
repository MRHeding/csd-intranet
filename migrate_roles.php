<?php
/**
 * Migration script to add role support to existing CSD Intranet installation
 * Run this if you already have an existing database without roles
 */

// Database configuration
$host = 'localhost';
$dbname = 'csd_intranet';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Starting migration to add role support...<br><br>";
    
    // Check if role column already exists
    $result = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($result->rowCount() == 0) {
        // Add role column to users table
        $pdo->exec("ALTER TABLE users ADD COLUMN role ENUM('admin', 'hr', 'employee') NOT NULL DEFAULT 'employee'");
        echo "Added 'role' column to users table.<br>";
        
        // Set admin role for admin user
        $pdo->exec("UPDATE users SET role = 'admin' WHERE username = 'admin'");
        echo "Set admin role for 'admin' user.<br>";
        
        // Set hr role for mike_johnson (example)
        $pdo->exec("UPDATE users SET role = 'hr' WHERE username = 'mike_johnson'");
        echo "Set hr role for 'mike_johnson' user.<br>";
        
    } else {
        echo "Role column already exists in users table.<br>";
    }
    
    // Check if created_by column exists in attendance table
    $result = $pdo->query("SHOW COLUMNS FROM attendance LIKE 'created_by'");
    if ($result->rowCount() == 0) {
        // Add created_by column to attendance table
        $pdo->exec("ALTER TABLE attendance ADD COLUMN created_by INT NOT NULL DEFAULT 1");
        $pdo->exec("ALTER TABLE attendance ADD FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE");
        echo "Added 'created_by' column to attendance table.<br>";
        
        // Add unique constraint for user_id and date
        $pdo->exec("ALTER TABLE attendance ADD UNIQUE KEY unique_user_date (user_id, date)");
        echo "Added unique constraint for user_id and date in attendance table.<br>";
        
    } else {
        echo "Created_by column already exists in attendance table.<br>";
    }
    
    // Check if created_by column exists in events table
    $result = $pdo->query("SHOW COLUMNS FROM events LIKE 'created_by'");
    if ($result->rowCount() == 0) {
        // Add created_by column to events table
        $pdo->exec("ALTER TABLE events ADD COLUMN created_by INT NOT NULL DEFAULT 1");
        $pdo->exec("ALTER TABLE events ADD FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE");
        echo "Added 'created_by' column to events table.<br>";
    } else {
        echo "Created_by column already exists in events table.<br>";
    }
    
    // Check if created_by column exists in reports table
    $result = $pdo->query("SHOW COLUMNS FROM reports LIKE 'created_by'");
    if ($result->rowCount() == 0) {
        // Add created_by column to reports table
        $pdo->exec("ALTER TABLE reports ADD COLUMN created_by INT NOT NULL DEFAULT 1");
        $pdo->exec("ALTER TABLE reports ADD FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE");
        echo "Added 'created_by' column to reports table.<br>";
    } else {
        echo "Created_by column already exists in reports table.<br>";
    }
    
    echo "<br>Migration completed successfully!<br>";
    echo "<br><strong>User Roles Summary:</strong><br>";
    
    $users = $pdo->query("SELECT username, email, role FROM users ORDER BY role, username")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        echo "- {$user['username']} ({$user['email']}) - Role: " . ucfirst($user['role']) . "<br>";
    }
    
    echo "<br><strong>Role-based Access Control Features:</strong><br>";
    echo "• <strong>Admin:</strong> Full access to all features<br>";
    echo "• <strong>HR:</strong> Can manage attendance, events, and reports for all users<br>";
    echo "• <strong>Employee:</strong> Can view events, mark own attendance, and view own attendance records<br>";
    
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "<br>";
}
?>
