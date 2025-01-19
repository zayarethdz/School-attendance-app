<?php
// register.php - Registration form for new students

// Include database connection and QR code generator
include_once '../includes/db.php';
include_once '../includes/qr_generator.php';

// Initialize variables
$name = $email = $password = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($name) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Email already registered.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new student into database
            $stmt = $conn->prepare("INSERT INTO students (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            if ($stmt->execute()) {
                // Generate QR code for the student
                $student_id = $stmt->insert_id;
                generateQRCode($student_id, $name);
                header("Location: login.php?success=Registration successful. Please log in.");
                exit();
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h2>Register New Student</h2>
        <?php
        // Display errors if any
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
        }
        ?>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>