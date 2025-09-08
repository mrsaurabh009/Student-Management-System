<?php
// Environment detection and configuration
// This file automatically detects if you're on local or live server

// Detect environment
function isLocalEnvironment() {
    $localHosts = ['localhost', '127.0.0.1', '::1'];
    return in_array($_SERVER['HTTP_HOST'] ?? 'localhost', $localHosts) || 
           strpos($_SERVER['HTTP_HOST'] ?? '', '.local') !== false;
}

// Load appropriate database configuration
if (isLocalEnvironment()) {
    // Local development environment
    define('DB_HOST', '127.0.0.1:3307');  // XAMPP MySQL with custom port
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'login_panel_db');
    define('ENVIRONMENT', 'local');
} else {
    // Live hosting environment
    // Update these with your actual hosting details
    define('DB_HOST', 'sql302.infinityfree.com');     
    define('DB_USER', 'if0_XXXXXXX');                 
    define('DB_PASS', 'your_database_password');      
    define('DB_NAME', 'if0_XXXXXXX_studentdb');       
    define('ENVIRONMENT', 'live');
}

// Create connection with environment-specific error handling
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
        if (ENVIRONMENT === 'local') {
            // Development - show detailed errors
            $error_msg = "Database Connection Error: " . $e->getMessage() . "<br>";
            $error_msg .= "<strong>Environment:</strong> " . ENVIRONMENT . "<br>";
            $error_msg .= "<strong>Host:</strong> " . DB_HOST . "<br>";
            $error_msg .= "<strong>Database:</strong> " . DB_NAME . "<br>";
            die($error_msg);
        } else {
            // Live - generic error message
            die("Database connection failed. Please contact administrator.");
        }
    }
}

// Helper function to get base URL
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'] . '/';
}

// Set error reporting based on environment
if (ENVIRONMENT === 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
