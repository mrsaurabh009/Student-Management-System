<?php
// Live hosting database configuration
// Update these values with your actual hosting details

// For InfinityFree hosting, use these format:
define('DB_HOST', 'sql302.infinityfree.com');     // Your hosting MySQL server
define('DB_USER', 'if0_XXXXXXX');                 // Your hosting username
define('DB_PASS', 'your_database_password');      // Your hosting password  
define('DB_NAME', 'if0_XXXXXXX_studentdb');       // Your hosting database name

// Create connection with error handling for live server
function getConnection() {
    try {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];
        
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", 
            DB_USER, 
            DB_PASS,
            $options
        );
        
        return $pdo;
        
    } catch(PDOException $e) {
        // For live server, don't show detailed errors
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            // Development environment - show detailed errors
            die("Database Connection Error: " . $e->getMessage());
        } else {
            // Live environment - show generic error
            die("Database connection failed. Please contact administrator.");
        }
    }
}
?>
