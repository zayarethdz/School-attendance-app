<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

// Check if the user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Initialize variables
$email = $password = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Authenticate user
    if (authenticateUser($email, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Login - High School Attendance App</title>
</head>
<body>
    <?php include '../components/header.php'; ?>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
    <?php include '../components/footer.php'; ?>
</body>
</html>