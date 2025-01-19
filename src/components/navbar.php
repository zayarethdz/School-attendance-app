<?php
// navbar.php
session_start();

// Function to check user role
function getUserRole() {
    return isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'guest';
}

// Navigation links based on user role
function renderNavbar() {
    $role = getUserRole();
    echo '<nav>';
    echo '<ul>';
    echo '<li><a href="index.php">Home</a></li>';
    
    if ($role === 'student') {
        echo '<li><a href="pages/dashboard.php">Dashboard</a></li>';
        echo '<li><a href="pages/attendance/history.php">Attendance History</a></li>';
    } elseif ($role === 'teacher') {
        echo '<li><a href="pages/dashboard.php">Dashboard</a></li>';
        echo '<li><a href="pages/student/read.php">Manage Students</a></li>';
        echo '<li><a href="pages/attendance/mark.php">Mark Attendance</a></li>';
    } elseif ($role === 'admin') {
        echo '<li><a href="pages/dashboard.php">Dashboard</a></li>';
        echo '<li><a href="pages/student/create.php">Add Student</a></li>';
        echo '<li><a href="pages/student/read.php">View Students</a></li>';
        echo '<li><a href="pages/attendance/report.php">Attendance Reports</a></li>';
    } else {
        echo '<li><a href="pages/login.php">Login</a></li>';
        echo '<li><a href="pages/register.php">Register</a></li>';
    }
    
    echo '</ul>';
    echo '</nav>';
}

// Render the navigation bar
renderNavbar();
?>