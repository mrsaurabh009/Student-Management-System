<?php
// Quick deployment setup checker
// Run this file on your live server to verify setup

echo "<h1>🚀 Student Management System - Deployment Setup</h1>";
echo "<p>Environment: " . (isLocalEnvironment() ? 'Local Development' : 'Live Server') . "</p>";

function isLocalEnvironment() {
    $localHosts = ['localhost', '127.0.0.1', '::1'];
    return in_array($_SERVER['HTTP_HOST'] ?? 'localhost', $localHosts);
}

// Test database connection
echo "<h2>📊 Database Connection Test</h2>";
try {
    require_once 'config/environment.php';
    $pdo = getConnection();
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
    
    // Test tables
    $tables = ['students', 'admin'];
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "<p style='color: green;'>✅ Table '$table' exists with $count records</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Table '$table' missing or inaccessible</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    echo "<h3>🔧 Solution:</h3>";
    echo "<ol>";
    echo "<li>Update database credentials in config/environment.php</li>";
    echo "<li>Make sure database exists and is accessible</li>";
    echo "<li>Import setup.sql file via phpMyAdmin</li>";
    echo "</ol>";
}

// Test file structure
echo "<h2>📁 File Structure Test</h2>";
$requiredFiles = [
    'index.php' => 'Main landing page',
    'admin_login.php' => 'Admin login form',
    'config/environment.php' => 'Database configuration',
    'auth/admin_auth.php' => 'Admin authentication',
    'dashboard/admin_dashboard.php' => 'Main dashboard',
    'uploads/profile_pics/' => 'Profile pictures folder'
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $description ($file)</p>";
    } else {
        echo "<p style='color: red;'>❌ Missing: $description ($file)</p>";
    }
}

// Test uploads folder permission
echo "<h2>📷 Upload Folder Permissions</h2>";
$uploadDir = 'uploads/profile_pics/';
if (is_dir($uploadDir)) {
    if (is_writable($uploadDir)) {
        echo "<p style='color: green;'>✅ Upload folder is writable</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Upload folder exists but may not be writable</p>";
        echo "<p>Solution: Set folder permissions to 755 or 777</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Upload folder missing</p>";
    echo "<p>Solution: Create 'uploads/profile_pics/' folder</p>";
}

// Display system info
echo "<h2>🖥️ System Information</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Current URL:</strong> " . (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "</p>";

// Final status
echo "<hr>";
echo "<h2>🎯 Next Steps:</h2>";
if (isLocalEnvironment()) {
    echo "<p>✅ Local development environment ready!</p>";
    echo "<p>📁 Access your project at: <a href='index.php'>index.php</a></p>";
} else {
    echo "<p>🌐 Live server deployment detected!</p>";
    echo "<p>🔑 Admin Login: <a href='admin_login.php'>admin_login.php</a></p>";
    echo "<p><strong>Credentials:</strong> admin / admin123</p>";
}

echo "<hr>";
echo "<p><strong>📱 Share your project:</strong></p>";
echo "<p>🔗 GitHub: <a href='https://github.com/mrsaurabh009/Student-Management-System' target='_blank'>Student Management System</a></p>";
echo "<p>💼 Add this to your portfolio and LinkedIn!</p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background: #f5f5f5;
}
h1, h2 { color: #333; }
p { margin: 10px 0; }
a { color: #667eea; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
