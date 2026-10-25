<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__. "/../../models/examModel.php";

$exams = getActiveExams();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Exams</title>
</head>
<body>

    <h1>Available Exams</h1>

    <p>Choose an exam to start your test.</p>

    <a href="dashboard.php">Back to Dashboard</a>

    <h2>Exam List</h2>
    <table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Exam ID</th>
        <th>Exam Title</th>
        <th>Description</th>
        <th>Duration</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php
    while ($row = mysqli_fetch_assoc($exams)) {
    ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['description'] ?? ''); ?></td>
            <td><?php echo $row['duration']; ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
            <a href="startExam.php?id=<?php echo (int)$row['id']; ?>">
            Start Exam
            </a>
        </td>
        </tr>
    <?php
    }
    ?>
</table>

</body>
</html>