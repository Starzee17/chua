

ZIPS Chau E-Library
A secure digital library system for the Zambia Institute of Purchasing and Supply (ZIPS) Chalimbana University Chapter.

Features
PIN-Protected Access: Secure library access with PIN code (zips2025)
Multi-Media Storage: Store and manage modules, pictures, videos, and articles
Graduate Directory: Publish names and details of graduates
Contact System: Built-in contact form with message management
Admin Panel: Complete content management system
Shareable Links: Easy sharing with automatic PIN protection
Responsive Design: Works on desktop, tablet, and mobile devices
Installation Instructions
Requirements
PHP 7.4 or higher
MySQL 5.7 or higher
Apache/Nginx web server
XAMPP, WAMP, or LAMP (recommended for local development)
Step 1: Setup Environment
Download and install XAMPP/WAMP
Start Apache and MySQL services
Step 2: Database Setup
Open phpMyAdmin (http://localhost/phpmyadmin)
Create a new database called zips_chau_elibrary
Import the database.sql file:
Click on the database name
Go to "Import" tab
Choose database.sql file
Click "Go"
Step 3: Configure Database Connection
Open config.php
Update the following if needed:
define('DB_HOST', 'localhost');

define('DB_USER', 'root');

define('DB_PASS', '');

define('DB_NAME', 'zips_chau_elibrary');
Step 4: File Permissions
Ensure the uploads folder has write permissions:

chmod -R 755 uploads/
Step 5: Deploy Files
Copy all files to your web server directory:
XAMPP: C:\xampp\htdocs\zips-chau-elibrary\
WAMP: C:\wamp64\www\zips-chau-elibrary\
Linux: /var/www/html/zips-chau-elibrary/
Step 6: Access the System
E-Library Access: http://localhost/zips-chau-elibrary/

PIN: zips2025
Admin Panel: http://localhost/zips-chau-elibrary/admin/

Username: admin
Password: admin123
IMPORTANT: Change this password immediately after first login!
Usage Guide
For Users
Enter PIN (zips2025) on the homepage
Browse available content:
Modules: Download course materials
Pictures: View photo gallery
Videos: Watch educational videos
Articles: Read articles and publications
Graduates: See list of graduates
About: Learn about ZIPS Chau Chapter
Contact: Send messages to administrators
For Administrators
Login to admin panel
Dashboard shows statistics and quick actions
Manage content:
Upload Modules: Add PDF, DOCX, PPTX files
Upload Pictures: Add JPG, PNG images
Upload Videos: Add MP4 videos
Add Articles: Write and publish articles
Add Graduates: Record graduate information
View Messages: Check contact form submissions
File Structure
zips-chau-elibrary/
├── admin/                  # Admin panel files
│   ├── includes/          # Admin components
│   ├── dashboard.php      # Admin dashboard
│   ├── login.php          # Admin login
│   └── ...
├── css/                   # Stylesheets
│   └── style.css
├── js/                    # JavaScript files
│   ├── main.js
│   └── lightbox.js
├── includes/              # Shared components
│   ├── header.php
│   └── footer.php
├── uploads/               # Uploaded files
│   ├── modules/
│   ├── pictures/
│   └── videos/
├── config.php             # Database configuration
├── database.sql           # Database structure
├── index.php              # Login page
├── dashboard.php          # Main dashboard
├── modules.php            # Modules page
├── pictures.php           # Gallery page
├── videos.php             # Videos page
├── articles.php           # Articles page
├── graduates.php          # Graduates page
├── about.php              # About page
├── contact.php            # Contact page
└── README.md              # This file
Security Notes
Change Default Credentials: Update admin password immediately
File Upload Security: Only allow specific file types
PIN Security: Change the access PIN in config.php
Database Security: Use strong database passwords
HTTPS: Use SSL certificate in production
Backup: Regularly backup database and uploads folder
Contact Information
Email: chau@zips.com
Facebook: Zambia Institute of Purchasing and Supply - Chalimbana University
Established: July 2023
About ZIPS Chau Chapter
The chapter was formed in July 2023 to bridge the gap between procurement theory and practical skills at Chalimbana University.

Support
For technical support or questions, contact the development team or visit the ZIPS Chau Facebook page.

License
© 2023-2024 ZIPS Chau E-Library. All rights reserved