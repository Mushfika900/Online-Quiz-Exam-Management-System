<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}
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

</body>
</html>