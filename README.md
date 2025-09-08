# 🎓 Student Management System

A modern, responsive **Student Management System** built with **PHP** and **MySQL** featuring admin authentication, student data management, and profile picture upload functionality.

## 🌐 **Live Demo**
🔗 **[View Live Project](https://your-live-url.com)** *(Will be updated after deployment)*

## 📸 **Screenshots**

### Admin Dashboard
![Admin Dashboard](https://via.placeholder.com/800x400/ff6b6b/white?text=Admin+Dashboard)
*Clean and modern admin interface with student management capabilities*

### Student Edit Modal
![Edit Modal](https://via.placeholder.com/600x400/667eea/white?text=Edit+Student+Modal)
*Intuitive modal for editing student details and uploading profile pictures*

## ✨ **Features**

### 🔐 **Admin Authentication**
- Secure login system for administrators
- Session management and protection
- Password hashing with bcrypt

### 👥 **Student Management**
- View all students in a professional table
- Real-time editing with AJAX
- Add, update, and manage student records
- Search and filter capabilities

### 📷 **Profile Picture Management**
- Upload and update student profile pictures
- Image validation (JPG, PNG, GIF)
- File size limits (2MB max)
- Automatic old image cleanup

### 🎨 **Modern UI/UX**
- Responsive design for all devices
- Beautiful gradients and animations
- Professional modal dialogs
- Hover effects and smooth transitions

## 🛠️ **Tech Stack**

| Technology | Usage |
|------------|-------|
| ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) | Backend Development |
| ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white) | Database Management |
| ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black) | Frontend Interactivity |
| ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white) | Structure & Markup |
| ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white) | Styling & Design |

## 📂 **Project Structure**

```
Student-Management-System/
├── 📁 auth/                    # Authentication handlers
│   ├── admin_auth.php         # Admin login processing
│   └── logout.php             # Logout functionality
├── 📁 config/                 # Configuration files
│   └── database.php           # Database connection
├── 📁 dashboard/              # Admin dashboard
│   ├── admin_dashboard_fixed.php  # Main dashboard
│   ├── get_student.php        # Fetch student data
│   ├── update_student_fixed.php   # Update student details
│   └── update_profile_picture.php # Profile picture upload
├── 📁 uploads/profile_pics/   # Profile picture storage
├── 📄 index.php              # Landing page
├── 📄 admin_login.php         # Admin login form
├── 📄 setup.sql              # Database setup script
└── 📄 README.md               # Project documentation
```

## 🚀 **Getting Started**

### Prerequisites
- **XAMPP** or **WAMP** (Apache + PHP + MySQL)
- Web browser
- Git (for cloning)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/mrsaurabh009/Student-Management-System.git
   cd Student-Management-System
   ```

2. **Setup XAMPP**
   - Install and start Apache + MySQL services
   - Copy project to `htdocs` folder

3. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Import `setup.sql` file
   - Database: `login_panel_db`

4. **Configure Database** (if needed)
   ```php
   // config/database.php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'login_panel_db');
   ```

5. **Access Application**
   ```
   http://localhost/Student-Management-System/
   ```

## 🔑 **Demo Credentials**

### Admin Login
- **Username:** `admin`
- **Password:** `admin123`

### Sample Students (All use password: `student123`)
- saurabh1112004@gmail.com
- rishi111@gmail.com
- gaurav2007@gmail.com
- ms2004@gmail.com
- satyam001@gmail.com

## 🎯 **Key Features Demonstration**

### 1. **Admin Authentication**
```php
// Secure password hashing
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Session management
$_SESSION['admin_id'] = $admin['id'];
$_SESSION['user_type'] = 'admin';
```

### 2. **AJAX Student Updates**
```javascript
// Real-time updates without page refresh
const response = await fetch('update_student_fixed.php', {
    method: 'POST',
    body: formData
});
```

### 3. **File Upload Security**
```php
// File validation and security
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_file_size = 2 * 1024 * 1024; // 2MB
```

## 🔒 **Security Features**

- ✅ **SQL Injection Prevention** - PDO prepared statements
- ✅ **Password Security** - bcrypt hashing
- ✅ **File Upload Validation** - Type and size restrictions
- ✅ **Session Management** - Secure admin sessions
- ✅ **Input Sanitization** - XSS prevention

## 📱 **Responsive Design**

- 📱 **Mobile Friendly** - Works on all screen sizes
- 💻 **Desktop Optimized** - Full featured desktop experience
- 🎨 **Modern UI** - Professional gradients and animations

## 🚀 **Deployment**

### Local Development
```bash
# Clone and setup
git clone https://github.com/mrsaurabh009/Student-Management-System.git
cd Student-Management-System
# Follow installation steps above
```

### Live Deployment
- Compatible with shared hosting providers
- Requires PHP 7.4+ and MySQL 5.7+
- Upload files via FTP/cPanel

## 🤝 **Contributing**

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 **License**

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 **Author**

**Saurabh Kumar**
- GitHub: [@mrsaurabh009](https://github.com/mrsaurabh009)
- LinkedIn: [Connect with me](https://linkedin.com/in/mrsaurabh009)
- Email: saurabhkr1112004@gmail.com

## 🙏 **Acknowledgments**

- Clean and modern UI design inspiration
- Security best practices implementation
- Responsive design principles

## 📊 **Project Stats**

![GitHub repo size](https://img.shields.io/github/repo-size/mrsaurabh009/Student-Management-System)
![GitHub stars](https://img.shields.io/github/stars/mrsaurabh009/Student-Management-System)
![GitHub forks](https://img.shields.io/github/forks/mrsaurabh009/Student-Management-System)

---

⭐ **If you found this project helpful, please give it a star!** ⭐
