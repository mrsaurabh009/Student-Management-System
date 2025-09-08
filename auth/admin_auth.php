<?php
session_start();
require_once '../config/database.php';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../admin_login.php");
        exit;
    }
    
    try {
        $pdo = getConnection();
        
        // Check if admin exists with given username
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && password_verify($password, $admin['password'])) {
            // Login successful
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['user_type'] = 'admin';
            
            header("Location: ../dashboard/admin_dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: ../admin_login.php");
            exit;
        }
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error. Please try again later.";
        header("Location: ../admin_login.php");
        exit;
    }
} else {
    header("Location: ../admin_login.php");
    exit;
}
?>
