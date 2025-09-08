<?php
session_start();
require_once '../config/database.php';


if (!isset($_SESSION['admin_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../admin_login.php");
    exit;
}


$student_data = null;
$error = null;
$success = null;


if ($_POST && isset($_POST['fetch_student'])) {
    $email = trim($_POST['student_email']);
    $password = trim($_POST['student_password']);
    
    if (empty($email) || empty($password)) {
        $error = "Please fill in both email and password fields.";
    } else {
        try {
            $pdo = getConnection();
            
            // Verify student credentials and fetch data
            $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
            $stmt->execute([$email]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($student && password_verify($password, $student['password'])) {
                $student_data = $student;
                $success = "Student data fetched successfully!";
            } else {
                $error = "Invalid student email or password.";
            }
            
        } catch (PDOException $e) {
            $error = "Database error occurred while fetching student data.";
        }
    }
}


try {
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Fetch student statistics
    $stmt = $pdo->prepare("SELECT COUNT(*) as total_students FROM students");
    $stmt->execute();
    $student_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'];
    
} catch (PDOException $e) {
    $error = "Database error occurred.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Data Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin-bottom: 10px;
        }
        .content {
            padding: 40px;
        }
        .stats-section {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
        }
        .stat-card {
            flex: 1;
            background: #f8f9ff;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #ff6b6b;
            max-width: 300px;
        }
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #ff6b6b;
            margin-bottom: 10px;
        }
        .stat-label {
            color: #666;
            font-size: 16px;
        }
        .admin-info {
            background: #fff5f5;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #ff6b6b;
        }
        .admin-info h3 {
            color: #d32f2f;
            margin-bottom: 15px;
        }
        .admin-info p {
            color: #555;
            margin: 5px 0;
        }
        .students-section h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ff6b6b;
        }
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .students-table th,
        .students-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .students-table th {
            background: #f8f9ff;
            color: #333;
            font-weight: bold;
        }
        .students-table tr:hover {
            background: #f8f9ff;
        }
        .profile-thumb {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ff6b6b;
        }
        .default-thumb {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        .logout-btn {
            background: #667eea;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.3s ease;
        }
        .logout-btn:hover {
            background: #5a67d8;
        }
        .no-students {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
        
        /* New styles for fetch form and student data */
        .fetch-section {
            background: #fff5f5;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #ff6b6b;
        }
        .fetch-section h2 {
            color: #d32f2f;
            margin-bottom: 15px;
        }
        .demo-credentials {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2196f3;
        }
        .demo-credentials h4 {
            color: #1976d2;
            margin-bottom: 10px;
        }
        .demo-credentials p {
            color: #555;
            margin: 5px 0;
            font-size: 14px;
        }
        .fetch-form {
            margin-top: 20px;
        }
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            flex: 1;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ff6b6b;
        }
        .fetch-btn {
            background: #ff6b6b;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .fetch-btn:hover {
            background: #ee5a24;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #dc3545;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
        
        /* Student data display styles */
        .student-data-section {
            background: #f0f8ff;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }
        .student-data-section h2 {
            color: #4c51bf;
            margin-bottom: 25px;
        }
        .student-profile {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }
        .profile-picture-section {
            text-align: center;
            min-width: 200px;
        }
        .student-profile-img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 4px solid #667eea;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .default-profile-large {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 60px;
            font-weight: bold;
            margin-bottom: 15px;
            border: 4px solid #667eea;
        }
        .profile-status {
            color: #666;
            font-size: 14px;
            font-style: italic;
        }
        .student-details {
            flex: 1;
        }
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .detail-label {
            font-weight: bold;
            color: #333;
            width: 150px;
            margin-right: 15px;
        }
        .detail-value {
            color: #555;
            flex: 1;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Student Data Management System</h1>
            <p>Welcome, <?php echo htmlspecialchars($admin['username']); ?>! These are the data of total available students.</p>
        </div>
        
        <div class="content">
            <div class="admin-info">
                <h3>Admin Information</h3>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($admin['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
                <p><strong>Account Created:</strong> <?php echo date('F j, Y', strtotime($admin['created_at'])); ?></p>
            </div>
            
            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $student_count; ?></div>
                    <div class="stat-label">Total Students in Database</div>
                </div>
            </div>
            
            <!-- Student Credentials Form -->
            <div class="fetch-section">
                <h2>Fetch Student Data</h2>
                <p style="color: #666; margin-bottom: 20px;">Enter student login credentials to retrieve their profile information:</p>
                
                <div class="demo-credentials">
                    <h4>Student Credentials:</h4>
                    <p><strong>Email:</strong> john.smith@email.com | <strong>Password:</strong> student123</p>
                    <p><em>You can use any of the 5 mock student accounts with password: student123</em></p>
                </div>

                <?php if ($error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" class="fetch-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="student_email">Student Email:</label>
                            <input type="email" id="student_email" name="student_email" required 
                                   value="<?php echo isset($_POST['student_email']) ? htmlspecialchars($_POST['student_email']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="student_password">Student Password:</label>
                            <input type="password" id="student_password" name="student_password" required>
                        </div>
                    </div>
                    <button type="submit" name="fetch_student" class="fetch-btn">Fetch Student Data</button>
                </form>
            </div>
            
            <!-- Student Data Display -->
            <?php if ($student_data): ?>
            <div class="student-data-section">
                <h2>Student Profile Information</h2>
                <div class="student-profile">
                    <div class="profile-picture-section">
                        <?php if (!empty($student_data['profile_picture']) && file_exists('../uploads/profile_pics/' . $student_data['profile_picture'])): ?>
                            <img src="../uploads/profile_pics/<?php echo htmlspecialchars($student_data['profile_picture']); ?>" 
                                 alt="Profile Picture" class="student-profile-img">
                        <?php else: ?>
                            <div class="default-profile-large">
                                <?php echo strtoupper(substr($student_data['name'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                        <p class="profile-status"><?php echo !empty($student_data['profile_picture']) ? 'Profile photo uploaded' : 'No profile photo'; ?></p>
                    </div>
                    
                    <div class="student-details">
                        <div class="detail-row">
                            <span class="detail-label">Full Name:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student_data['name']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email Address:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student_data['email']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Mobile Number:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($student_data['mobile']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Registration Date:</span>
                            <span class="detail-value"><?php echo date('F j, Y g:i A', strtotime($student_data['created_at'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Student ID:</span>
                            <span class="detail-value">#<?php echo str_pad($student_data['id'], 4, '0', STR_PAD_LEFT); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <a href="../auth/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
