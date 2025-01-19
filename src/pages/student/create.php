<?php
// Include database connection
include_once '../../includes/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $section = $_POST['section'];
    $year = $_POST['year'];

    // Validate input
    if (!empty($name) && !empty($email) && !empty($section) && !empty($year)) {
        // Prepare SQL statement to insert student
        $stmt = $conn->prepare("INSERT INTO students (name, email, section, year) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $section, $year);

        // Execute the statement
        if ($stmt->execute()) {
            // Generate QR code for the student
            include_once '../../includes/qr_generator.php';
            generateQRCode($email); // Assuming QR code is generated based on email

            echo "Student registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Estudiante</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php include_once '../../components/header.php'; ?>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="container">
        <h2>Registrar Nuevo Estudiante</h2>
        <form method="POST" action="">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="section">Sección:</label>
            <input type="text" id="section" name="section" required>

            <label for="year">Año:</label>
            <input type="text" id="year" name="year" required>

            <button type="submit">Registrar Estudiante</button>
        </form>
    </div>

    <?php include_once '../../components/footer.php'; ?>
</body>
</html>