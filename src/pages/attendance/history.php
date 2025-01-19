<?php
// Include database connection
include_once '../../includes/db.php';

// Start session
session_start();

// Check if user is logged in and has the appropriate role
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'teacher' && $_SESSION['role'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}

// Fetch attendance history based on filters
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');
$section = isset($_POST['section']) ? $_POST['section'] : 'A';

// Prepare SQL query to fetch attendance records
$sql = "SELECT students.name, attendance.date, attendance.status 
        FROM attendance 
        JOIN students ON attendance.student_id = students.id 
        WHERE YEAR(attendance.date) = ? AND students.section = ? 
        ORDER BY attendance.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $year, $section);
$stmt->execute();
$result = $stmt->get_result();

// Fetch attendance records
$attendanceRecords = [];
while ($row = $result->fetch_assoc()) {
    $attendanceRecords[] = $row;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Asistencia</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php include_once '../../components/header.php'; ?>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="container">
        <h1>Historial de Asistencia</h1>
        <form method="POST" action="history.php">
            <label for="year">Año:</label>
            <input type="number" name="year" id="year" value="<?php echo $year; ?>" required>
            <label for="section">Sección:</label>
            <select name="section" id="section">
                <option value="A" <?php echo ($section == 'A') ? 'selected' : ''; ?>>A</option>
                <option value="B" <?php echo ($section == 'B') ? 'selected' : ''; ?>>B</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nombre del Estudiante</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($attendanceRecords) > 0): ?>
                    <?php foreach ($attendanceRecords as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['name']); ?></td>
                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                            <td><?php echo htmlspecialchars($record['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No se encontraron registros de asistencia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include_once '../../components/footer.php'; ?>
</body>
</html>