<?php
// Include database connection and authentication files
include_once '../../includes/db.php';
include_once '../../includes/auth.php';

// Check if the user is authenticated and has the right role
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'teacher' && $_SESSION['role'] != 'admin')) {
    header('Location: ../login.php');
    exit();
}

// Function to mark attendance
function markAttendance($studentId, $date) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO attendance (student_id, date) VALUES (?, ?)");
    $stmt->bind_param("is", $studentId, $date);
    return $stmt->execute();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_POST['student_id'];
    $date = date('Y-m-d'); // Current date

    if (markAttendance($studentId, $date)) {
        $message = "Attendance marked successfully!";
    } else {
        $message = "Failed to mark attendance.";
    }
}

// Fetch students for dropdown
$students = [];
$result = $conn->query("SELECT id, name FROM students");
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php include_once '../../components/header.php'; ?>
    <?php include_once '../../components/navbar.php'; ?>

    <div class="container">
        <h2>Mark Attendance</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form method="POST" action="">
            <label for="student_id">Select Student:</label>
            <select name="student_id" id="student_id" required>
                <option value="">--Select Student--</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Mark Attendance</button>
        </form>
    </div>

    <?php include_once '../../components/footer.php'; ?>
</body>
</html>