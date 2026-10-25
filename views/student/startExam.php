<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$exam_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($exam_id <= 0) {
    die("Invalid Exam ID");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Exam</title>
</head>
<body>

    <h1>Start Exam</h1>

    <h2>Exam ID: <?php echo $exam_id; ?></h2>

    <p>Your exam questions will appear here.</p>

    <a href="availableExams.php">Back to Available Exams</a>

</body>
</html>