<?php
// update.php - This file allows administrators or teachers to update existing student records.

// Include database connection and authentication files
include_once '../../includes/db.php';
include_once '../../includes/auth.php';

// Check if the user is authenticated and has the right role
if (!isAuthenticated() || !hasRole(['admin', 'teacher'])) {
    header("Location: ../login.php");
    exit();
}

// Initialize variables
$studentId = $_GET['id'] ?? null;
$studentData = [];

// Fetch student data if ID is provided
if ($studentId) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->execute(['id' => $studentId]);
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $section = $_POST['section'];

    // Update student record in the database
    $stmt = $pdo->prepare("UPDATE students SET name = :name, email = :email, section = :section WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'section' => $section,
        'id' => $studentId
    ]);

    // Redirect to the student read page after update
    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Estudiante</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php include '../../components/header.php'; ?>
    <?php include '../../components/navbar.php'; ?>

    <div class="container">
        <h2>Actualizar Estudiante</h2>
        <form method="POST" action="">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($studentData['name'] ?? '') ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($studentData['email'] ?? '') ?>" required>

            <label for="section">Sección:</label>
            <select id="section" name="section" required>
                <option value="1A" <?= (isset($studentData['section']) && $studentData['section'] === '1A') ? 'selected' : '' ?>>1A</option>
                <option value="1B" <?= (isset($studentData['section']) && $studentData['section'] === '1B') ? 'selected' : '' ?>>1B</option>
                <!-- Add options for other sections as needed -->
            </select>

            <button type="submit">Actualizar</button>
        </form>
    </div>

    <?php include '../../components/footer.php'; ?>
</body>
</html>