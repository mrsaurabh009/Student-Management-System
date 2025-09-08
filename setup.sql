
CREATE DATABASE IF NOT EXISTS login_panel_db;
USE login_panel_db;

-- students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- admin table
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- mock student data (password is 'student123' hashed)
INSERT INTO students (name, email, mobile, password) VALUES
('Saurabh Kumar', 'saurabh@email.com', '1234567890', '$2y$10$YaLrBViRFQ.9WxCv2w17FefOqQg7eOVtInBn1y5UpOAiGb6a.YW7y'),
('Alice Johnson', 'alice.johnson@email.com', '2345678901', '$2y$10$YaLrBViRFQ.9WxCv2w17FefOqQg7eOVtInBn1y5UpOAiGb6a.YW7y'),
('Bob Wilson', 'bob.wilson@email.com', '3456789012', '$2y$10$YaLrBViRFQ.9WxCv2w17FefOqQg7eOVtInBn1y5UpOAiGb6a.YW7y'),
('Emma Davis', 'emma.davis@email.com', '4567890123', '$2y$10$YaLrBViRFQ.9WxCv2w17FefOqQg7eOVtInBn1y5UpOAiGb6a.YW7y'),
('Mike Brown', 'mike.brown@email.com', '5678901234', '$2y$10$YaLrBViRFQ.9WxCv2w17FefOqQg7eOVtInBn1y5UpOAiGb6a.YW7y');

-- admin data (password is 'admin123' hashed)
INSERT INTO admin (username, email, password) VALUES
('admin', 'admin@email.com', '$2y$10$asrH7klRiYe5w4LuXZW7TOJ5.NZgAmVdFzzEjtMsgwFaADfmsddGW');
('superadmin', 'admin1@gmail.com', '$2y$10$asrH7klRiYe5w4LuXZW7TOJ5.NZgAmVdFzzEjtMsgwFaADfmsddGW');
