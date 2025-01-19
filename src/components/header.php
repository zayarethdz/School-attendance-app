<?php
// header.php - This file contains the HTML and PHP code for the header section of the application

session_start(); // Start the session to access session variables

// Function to check if the user is logged in and return the appropriate greeting
function getGreeting() {
    if (isset($_SESSION['username'])) {
        return "Welcome, " . htmlspecialchars($_SESSION['username']);
    }
    return "Welcome to the High School Attendance App";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Link to the CSS stylesheet -->
    <title>High School Attendance App</title>
</head>
<body>
    <header>
        <h1><?php echo getGreeting(); ?></h1> <!-- Display greeting based on user session -->
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../pages/login.php">Login</a></li>
                <li><a href="../pages/register.php">Register</a></li>
                <?php if (isset($_SESSION['role'])): ?>
                    <li><a href="../pages/dashboard.php">Dashboard</a></li>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li><a href="../pages/student/read.php">Manage Students</a></li>
                    <?php endif; ?>
                    <li><a href="../pages/attendance/mark.php">Mark Attendance</a></li>
                    <li><a href="../includes/auth.php?action=logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>