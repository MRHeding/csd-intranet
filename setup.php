<?php
/**
 * CSD Intranet Database Setup Script
 * Run this script once to set up the database and create sample data
 */

// Database configuration
$host = 'localhost';
$dbname = 'csd_intranet';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server (without specifying database)
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Database '$dbname' created successfully or already exists.<br>";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read and execute schema
    $schema = file_get_contents('database/schema.sql');
    $statements = explode(';', $schema);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    echo "Database tables created successfully.<br>";
      // Insert sample users with roles
    $users = [
        ['john_doe', password_hash('password123', PASSWORD_DEFAULT), 'john.doe@csd.com', 'employee'],
        ['jane_smith', password_hash('password123', PASSWORD_DEFAULT), 'jane.smith@csd.com', 'employee'],
        ['mike_johnson', password_hash('password123', PASSWORD_DEFAULT), 'mike.johnson@csd.com', 'hr'],
        ['sarah_wilson', password_hash('password123', PASSWORD_DEFAULT), 'sarah.wilson@csd.com', 'employee'],
        ['admin', password_hash('admin123', PASSWORD_DEFAULT), 'admin@csd.com', 'admin']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
    }
    echo "Sample users created successfully.<br>";
    
    // Get user IDs with their roles for attendance records
    $userIds = $pdo->query("SELECT id FROM users")->fetchAll(PDO::FETCH_COLUMN);
    $adminId = $pdo->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1")->fetchColumn();
    $statuses = ['present', 'absent', 'leave'];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO attendance (user_id, date, status, created_by) VALUES (?, ?, ?, ?)");
    
    // Create attendance for the last 30 days
    for ($i = 30; $i >= 1; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        foreach ($userIds as $userId) {
            // 80% chance of being present, 15% absent, 5% leave
            $rand = rand(1, 100);
            if ($rand <= 80) {
                $status = 'present';
            } elseif ($rand <= 95) {
                $status = 'absent';            } else {
                $status = 'leave';
            }
            
            $stmt->execute([$userId, $date, $status, $adminId]);
        }
    }
    echo "Sample attendance records created successfully.<br>";
    
    // Insert sample events
    $events = [
        ['Monthly Team Meeting', 'Regular monthly meeting to discuss progress and upcoming projects.', date('Y-m-d H:i:s', strtotime('+1 week'))],
        ['Company Training Session', 'Professional development training for all employees.', date('Y-m-d H:i:s', strtotime('+2 weeks'))],
        ['Annual Company Picnic', 'Fun day out for all employees and their families.', date('Y-m-d H:i:s', strtotime('+1 month'))],
        ['Quarterly Review', 'Quarterly performance review and planning session.', date('Y-m-d H:i:s', strtotime('+3 days'))],
        ['New Employee Orientation', 'Welcome session for new team members.', date('Y-m-d H:i:s', strtotime('+5 days'))]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO events (title, description, event_date) VALUES (?, ?, ?)");
    foreach ($events as $event) {
        $stmt->execute($event);
    }
    echo "Sample events created successfully.<br>";
    
    // Insert sample reports
    $reports = [
        ['Monthly Attendance Report', 'Comprehensive attendance report for the current month showing attendance patterns and statistics.'],
        ['Employee Performance Summary', 'Summary of employee performance metrics and key achievements for the quarter.'],
        ['Event Participation Report', 'Analysis of employee participation in company events and activities.'],
        ['Department Productivity Report', 'Detailed analysis of departmental productivity and efficiency metrics.'],
        ['Training Completion Report', 'Status report on mandatory training completion across all departments.']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO reports (title, content) VALUES (?, ?)");
    foreach ($reports as $report) {
        $stmt->execute($report);
    }
    echo "Sample reports created successfully.<br>";
    
    echo "<h2>Setup Complete!</h2>";
    echo "<p>Your CSD Intranet system is now ready to use.</p>";
    echo "<h3>Sample Login Credentials:</h3>";
    echo "<ul>";
    echo "<li><strong>Admin:</strong> Username: admin, Password: admin123</li>";
    echo "<li><strong>User:</strong> Username: john_doe, Password: password123</li>";
    echo "<li><strong>User:</strong> Username: jane_smith, Password: password123</li>";
    echo "</ul>";
    echo "<p><a href='src/index.php' style='background-color: #3B82F6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to CSD Intranet</a></p>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
