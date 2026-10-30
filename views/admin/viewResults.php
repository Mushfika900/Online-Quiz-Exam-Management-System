<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__. "/../../models/resultModel.php";

$results = getAllExamResults();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Exam Results</title>
</head>
<body>

    <h1>View Exam Results</h1>

    <p>View all students' exam results.</p>

    <a href="dashboard.php">Back to Dashboard</a>

    <h2>Student Result List</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Result ID</th>
            <th>Student ID</th>
            <th>Exam Name</th>
            <th>Total Questions</th>
            <th>Correct Answers</th>
            <th>Score</th>
            <th>Submitted At</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($results)) {
        ?>
            <tr>
                <td><?php echo (int)$row['id']; ?></td>
                <td><?php echo (int)$row['user_id']; ?></td>
                <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                <td><?php echo (int)$row['total_questions']; ?></td>
                <td><?php echo (int)$row['correct_answers']; ?></td>
                <td><?php echo htmlspecialchars($row['score']); ?>%</td>
                <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

</body>
</html>