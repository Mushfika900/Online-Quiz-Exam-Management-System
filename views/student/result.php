<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__. "/../../models/resultModel.php";

$user_id = $_SESSION['user_id'];

$exam_id = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;

if ($exam_id <= 0) {
    die("Invalid Exam ID");
}

$result = getStudentResult($user_id, $exam_id);

if (!$result) {
    die("Result not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
</head>
<body>

    <h1>Exam Result</h1>

    <h2>Your Exam Performance</h2>

    <p>
        <strong>Exam Name:</strong>
        <?php echo htmlspecialchars($result['exam_name']); ?>
    </p>

    <p>
        <strong>Total Questions:</strong>
        <?php echo $result['total_questions']; ?>
    </p>

    <p>
        <strong>Correct Answers:</strong>
        <?php echo $result['correct_answers']; ?>
    </p>

    <p>
        <strong>Score:</strong>
        <?php echo $result['score']; ?>%
    </p>

    <p>
        <strong>Submitted At:</strong>
        <?php echo $result['submitted_at']; ?>
    </p>

    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>