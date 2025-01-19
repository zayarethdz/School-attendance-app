<?php
session_start();

// Include configuration and database connection
require_once 'config.php';
require_once 'includes/db.php';
require_once 'includes/auth.php';

// Check if user is logged in and redirect accordingly
if (isLoggedIn()) {
    // Redirect to dashboard based on user role
    $role = $_SESSION['user_role'];
    if ($role == 'admin') {
        header('Location: pages/dashboard.php');
    } elseif ($role == 'teacher') {
        header('Location: pages/dashboard.php');
    } elseif ($role == 'student') {
        header('Location: pages/dashboard.php');
    }
    exit();
}

// If not logged in, redirect to login page
header('Location: pages/login.php');
exit();
?>