# High School Attendance Application

## Overview
The High School Attendance Application is a web-based system designed to manage and track student attendance in a secondary school setting. It provides functionalities for user authentication, student management, attendance marking, and report generation.

## Features
1. **User Authentication**: Supports three roles - Students, Teachers, and Administrators.
2. **Student Management**: 
   - Create, Read, Update, and Delete (CRUD) operations for student records.
   - QR code generation upon student registration.
3. **Attendance Tracking**:
   - Daily attendance registration using QR codes.
   - Attendance can be marked for individual students or entire classes.
4. **Attendance History**: 
   - View attendance history by student and by class, filtered by year and section (1° to 6°, sections A and B).
5. **Report Generation**:
   - Generate attendance reports for weekly, biweekly, and monthly periods.
   - Download reports in PDF or Excel format.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## Project Structure
```
high-school-attendance-app
├── src
│   ├── assets
│   │   ├── css
│   │   │   └── styles.css
│   │   ├── js
│   │   │   └── scripts.js
│   │   └── images
│   ├── components
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── navbar.php
│   ├── pages
│   │   ├── login.php
│   │   ├── register.php
│   │   ├── dashboard.php
│   │   ├── student
│   │   │   ├── create.php
│   │   │   ├── read.php
│   │   │   ├── update.php
│   │   │   └── delete.php
│   │   ├── attendance
│   │   │   ├── mark.php
│   │   │   ├── history.php
│   │   │   └── report.php
│   ├── includes
│   │   ├── db.php
│   │   ├── auth.php
│   │   └── qr_generator.php
│   ├── index.php
│   └── config.php
├── database
│   └── schema.sql
├── vendor
│   └── autoload.php
├── .htaccess
├── composer.json
└── README.md
```

## Installation
1. Clone the repository to your local machine.
2. Set up a MySQL database and import the `schema.sql` file located in the `database` directory.
3. Update the database connection settings in `src/config.php`.
4. Install PHP dependencies using Composer.
5. Access the application through a web server that supports PHP.

## Usage
- Navigate to the login page to authenticate as a user.
- Depending on your role, you can manage student records, mark attendance, and generate reports.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License.