# Student Data Management System - Usage Guide

## How the System Works

This system allows an admin to fetch and display student data by entering the student's login credentials. Here's the complete workflow:

## Step-by-Step Usage

### 1. Setup the System
1. Install XAMPP and start Apache + MySQL services
2. Copy the project folder to `htdocs`
3. Import `setup.sql` in phpMyAdmin to create the database
4. Access the system at: `http://localhost/PHP%20Login%20Panel/`

### 2. Admin Login
1. Click "Admin Login" on the home page
2. Enter credentials:
   - **Username**: admin
   - **Password**: admin123
3. Click "Login"

### 3. Fetch Student Data
Once logged in as admin, you'll see the admin dashboard with:

1. **Admin Information** section - shows your admin details
2. **Statistics** section - shows total students in database
3. **Fetch Student Data** section - the main functionality

#### To fetch a student's data:
1. In the "Fetch Student Data" form, enter:
   - **Student Email**: Use one of these demo emails:
     - john.smith@email.com
     - alice.johnson@email.com
     - bob.wilson@email.com
     - emma.davis@email.com
     - mike.brown@email.com
   - **Student Password**: student123 (same for all demo students)
2. Click "Fetch Student Data"

### 4. View Student Information
After successfully entering student credentials, the system will display:

- **Student Profile Picture** (if uploaded, otherwise shows default avatar)
- **Complete Student Details**:
  - Full Name
  - Email Address
  - Mobile Number
  - Registration Date
  - Student ID

## Key Features

### ✅ Admin Authentication
- Only authenticated admins can access the system
- Secure session management

### ✅ Student Data Fetching
- Validates student credentials before displaying data
- Shows detailed error messages for invalid credentials
- Preserves form data on validation errors

### ✅ Profile Picture Support
- Displays student profile pictures if available
- Shows default avatar with student's initial if no photo
- Indicates photo upload status

### ✅ Professional UI
- Clean, modern design
- Color-coded sections for different types of information
- Responsive layout that works on different screen sizes
- Success/error messaging

## Security Features

1. **Password Hashing**: All passwords are securely hashed using PHP's `password_hash()`
2. **SQL Injection Protection**: Uses PDO prepared statements
3. **Session Security**: Proper session management with user type validation
4. **Input Validation**: Validates all form inputs before processing

## Database Structure

The system uses two main tables:

### Students Table
- ID, Name, Email, Mobile, Password (hashed), Profile Picture, Registration Date

### Admin Table  
- ID, Username, Email, Password (hashed), Registration Date

## Error Handling

The system provides clear feedback for various scenarios:
- ✅ "Student data fetched successfully!" - when credentials are valid
- ❌ "Invalid student email or password." - when credentials don't match
- ❌ "Please fill in both email and password fields." - when fields are empty
- ❌ "Database error occurred..." - for database connection issues

## Troubleshooting

### Common Issues:
1. **"Database error"** - Check if MySQL is running and database exists
2. **"Invalid credentials"** - Double-check the demo emails and ensure password is "student123"
3. **Page not loading** - Verify Apache is running and files are in correct htdocs location

### Demo Credentials Quick Reference:
**Admin**: admin / admin123
**Students**: Any of the 5 emails listed above with password "student123"

## Files Structure

```
PHP Login Panel/
├── index.php                    # Main landing page
├── admin_login.php             # Admin login form
├── setup.sql                   # Database setup script
├── USAGE_GUIDE.md             # This guide
├── README.md                  # Technical documentation
├── config/database.php        # Database configuration
├── auth/
│   ├── admin_auth.php         # Admin authentication
│   └── logout.php             # Logout handler
└── dashboard/
    └── admin_dashboard.php    # Admin dashboard with student data fetching
```

This system is perfect for scenarios where an administrator needs to access student information using the student's own credentials, such as help desk support or account verification purposes.
