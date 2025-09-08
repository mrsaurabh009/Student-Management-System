<?php

echo "<h2>Password Hash Generator</h2>\n";
echo "<p>Copy these hashed passwords to your setup.sql file:</p>\n\n";

$student_password = "student123";
$admin_password = "admin123";

$student_hash = password_hash($student_password, PASSWORD_DEFAULT);
$admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);

echo "<h3>Student Password Hash (for password: student123):</h3>\n";
echo "<code>" . $student_hash . "</code>\n\n";

echo "<h3>Admin Password Hash (for password: admin123):</h3>\n";
echo "<code>" . $admin_hash . "</code>\n\n";

echo "<h3>Updated SQL INSERT statements:</h3>\n";
echo "<pre>";
echo "-- Insert mock student data\n";
echo "INSERT INTO students (name, email, mobile, password) VALUES\n";
echo "('saurabh Kumar', 'saurabh@email.com', '1234567890', '$student_hash'),\n";
echo "('Alice Johnson', 'alice.johnson@email.com', '2345678901', '$student_hash'),\n";
echo "('Bob Wilson', 'bob.wilson@email.com', '3456789012', '$student_hash'),\n";
echo "('Emma Davis', 'emma.davis@email.com', '4567890123', '$student_hash'),\n";
echo "('Mike Brown', 'mike.brown@email.com', '5678901234', '$student_hash');\n\n";

echo "-- Insert admin data\n";
echo "INSERT INTO admin (username, email, password) VALUES\n";
echo "('admin', 'admin@email.com', '$admin_hash');\n";
echo "</pre>";
?>
