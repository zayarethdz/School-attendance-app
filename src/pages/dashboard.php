<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Get user role
$userRole = $_SESSION['user_role'];

// Fetch relevant data based on user role
$students = [];
if ($userRole === 'admin' || $userRole === 'teacher') {
    $query = "SELECT * FROM students";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
}

// Fetch attendance data if user is a teacher or admin
$attendanceData = [];
if ($userRole === 'admin' || $userRole === 'teacher') {
    $attendanceQuery = "SELECT * FROM attendance";
    $attendanceResult = mysqli_query($conn, $attendanceQuery);
    while ($row = mysqli_fetch_assoc($attendanceResult)) {
        $attendanceData[] = $row;
    }
}

// Include header and navbar
include '../components/header.php';
include '../components/navbar.php';
?>

<div class="container">
    <h1>Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['user_name']; ?>!</p>

    <?php if ($userRole === 'admin' || $userRole === 'teacher'): ?>
        <h2>Student List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td>
                            <a href="student/update.php?id=<?php echo $student['id']; ?>">Edit</a>
                            <a href="student/delete.php?id=<?php echo $student['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Attendance Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendanceData as $attendance): ?>
                    <tr>
                        <td><?php echo $attendance['student_id']; ?></td>
                        <td><?php echo $attendance['date']; ?></td>
                        <td><?php echo $attendance['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h2>Your Attendance</h2>
        <!-- Display individual student attendance here -->
    <?php endif; ?>
</div>

<?php include '../components/footer.php'; ?>