<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['student_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: ../student_login.php");
    exit;
}

if ($_POST && isset($_FILES['profile_pic'])) {
    $student_id = $_SESSION['student_id'];
    $upload_dir = '../uploads/profile_pics/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_file_size = 2 * 1024 * 1024; // 2MB
  

    $file = $_FILES['profile_pic'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = $file['type'];
    $file_error = $file['error'];

    if ($file_error !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Upload failed. Please try again.";
        header("Location: student_dashboard.php");
        exit;
    }

    if ($file_size > $max_file_size) {
        $_SESSION['error'] = "File size too large. Maximum allowed size is 2MB.";
        header("Location: student_dashboard.php");
        exit;
    }

    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['error'] = "Invalid file type. Only JPG, PNG and GIF are allowed.";
        header("Location: student_dashboard.php");
        exit;
    }

    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_filename = 'profile_' . $student_id . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . $new_filename;

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($file_tmp, $upload_path)) {
        try {
            $pdo = getConnection();
            

            $stmt = $pdo->prepare("SELECT profile_picture FROM students WHERE id = ?");
            $stmt->execute([$student_id]);
            $current = $stmt->fetch(PDO::FETCH_ASSOC);
            

            $stmt = $pdo->prepare("UPDATE students SET profile_picture = ? WHERE id = ?");
            if ($stmt->execute([$new_filename, $student_id])) {

                if ($current && !empty($current['profile_picture']) && file_exists($upload_dir . $current['profile_picture'])) {
                    unlink($upload_dir . $current['profile_picture']);
                }
                
                $_SESSION['success'] = "Profile picture updated successfully!";
            } else {

                if (file_exists($upload_path)) {
                    unlink($upload_path);
                }
                $_SESSION['error'] = "Failed to update profile picture in database.";
            }
        } catch (PDOException $e) {

            if (file_exists($upload_path)) {
                unlink($upload_path);
            }
            $_SESSION['error'] = "Database error occurred while updating profile picture.";
        }
    } else {
        $_SESSION['error'] = "Failed to upload file. Please try again.";
    }
} else {
    $_SESSION['error'] = "No file was uploaded.";
}

header("Location: student_dashboard.php");
exit;
?>
