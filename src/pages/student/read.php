<?php
// Include database connection
include_once '../../includes/db.php';

// Start session
session_start();

// Check if user is logged in and has the appropriate role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Fetch students from the database
$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

// Fetch all students into an array
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php include_once '../../components/header.php'; ?>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="container">
        <h1>Lista de Estudiantes</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Sección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['id']); ?></td>
                        <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['section']); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $student['id']; ?>">Actualizar</a>
                            <a href="delete.php?id=<?php echo $student['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include_once '../../components/footer.php'; ?>
</body>
</html>