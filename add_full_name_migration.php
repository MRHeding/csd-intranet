<?php
/**
 * Migration script to add full_name column to users table
 * Run this script once to update existing database
 */

require_once 'src/config/database.php';

try {
    // Check if full_name column already exists
    $checkColumn = $pdo->query("SHOW COLUMNS FROM users LIKE 'full_name'");
    
    if ($checkColumn->rowCount() == 0) {
        // Add full_name column after username
        $sql = "ALTER TABLE users ADD COLUMN full_name VARCHAR(100) NOT NULL AFTER username";
        $pdo->exec($sql);
        echo "✓ Successfully added full_name column to users table\n";
        
        // Update existing users with a default full name (they can update it later)
        $updateSql = "UPDATE users SET full_name = CONCAT(UPPER(LEFT(username, 1)), SUBSTRING(username, 2)) WHERE full_name = ''";
        $pdo->exec($updateSql);
        echo "✓ Updated existing users with default full names\n";
    } else {
        echo "ℹ full_name column already exists\n";
    }
    
    echo "Migration completed successfully!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
