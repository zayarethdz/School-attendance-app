<?php
// delete.php - This file provides functionality to delete student records

// Include database connection
include_once '../../includes/db.php';

// Check if the user is authenticated and has the right role
include_once '../../includes/auth.php';

// Check if the student ID is provided
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the student list page with a success message
        header("Location: read.php?message=Student deleted successfully");
        exit();
    } else {
        // Redirect to the student list page with an error message
        header("Location: read.php?message=Error deleting student");
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect to the student list page if no ID is provided
    header("Location: read.php?message=No student ID provided");
    exit();
}

// Close the database connection
$conn->close();
?>