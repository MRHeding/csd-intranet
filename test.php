<?php
/**
 * Test script to verify system functionality
 */

// Include the database config
require_once 'src/config/database.php';

echo "<h1>CSD Intranet System Test</h1>";

// Test database connection
try {
    $stmt = $pdo->query("SELECT 1");
    echo "<p style='color: green;'>✓ Database connection successful</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Test if tables exist
$tables = ['users', 'attendance', 'events', 'reports'];
$tablesExist = true;

foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT 1 FROM $table LIMIT 1");
        echo "<p style='color: green;'>✓ Table '$table' exists</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>✗ Table '$table' missing</p>";
        $tablesExist = false;
    }
}

if (!$tablesExist) {
    echo "<p><strong>Please run setup.php first to create the database tables.</strong></p>";
} else {
    echo "<h2>System Status: Ready!</h2>";
    echo "<p><a href='src/index.php' style='background-color: #3B82F6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to CSD Intranet</a></p>";
}
?>
