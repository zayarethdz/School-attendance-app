<?php
// report.php - Generates attendance reports for specified periods and allows downloading in PDF or Excel format.

session_start();
include_once '../../includes/db.php';
include_once '../../includes/auth.php';

// Check if user is authenticated and has the right role
if (!isAuthenticated() || !isAdmin()) {
    header("Location: ../../login.php");
    exit();
}

// Function to generate report based on selected period
function generateReport($period, $year, $section) {
    global $conn;
    $query = "SELECT * FROM attendance WHERE year = ? AND section = ? AND period = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $year, $section, $period);
    $stmt->execute();
    return $stmt->get_result();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $period = $_POST['period'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $attendanceData = generateReport($period, $year, $section);
    
    // Logic to generate PDF or Excel file can be added here
    // For now, just display the data
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte de Asistencia</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php include_once '../components/header.php'; ?>
    <?php include_once '../components/navbar.php'; ?>

    <div class="container">
        <h1>Generar Reporte de Asistencia</h1>
        <form method="POST" action="report.php">
            <label for="period">Periodo:</label>
            <select name="period" id="period" required>
                <option value="weekly">Semanal</option>
                <option value="biweekly">Quincenal</option>
                <option value="monthly">Mensual</option>
            </select>

            <label for="year">Año:</label>
            <input type="number" name="year" id="year" required>

            <label for="section">Sección:</label>
            <select name="section" id="section" required>
                <option value="1A">1° A</option>
                <option value="1B">1° B</option>
                <option value="2A">2° A</option>
                <option value="2B">2° B</option>
                <option value="3A">3° A</option>
                <option value="3B">3° B</option>
                <option value="4A">4° A</option>
                <option value="4B">4° B</option>
                <option value="5A">5° A</option>
                <option value="5B">5° B</option>
                <option value="6A">6° A</option>
                <option value="6B">6° B</option>
            </select>

            <button type="submit">Generar Reporte</button>
        </form>

        <?php if (isset($attendanceData)): ?>
            <h2>Reporte de Asistencia</h2>
            <table>
                <tr>
                    <th>ID Estudiante</th>
                    <th>Nombre</th>
                    <th>Asistencia</th>
                </tr>
                <?php while ($row = $attendanceData->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['student_id']; ?></td>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['attendance_status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>

    <?php include_once '../components/footer.php'; ?>
</body>
</html>