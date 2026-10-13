<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>

    <link rel="stylesheet" href="../css/createExam.css">
</head>
<body>

    <div class="header">
        <h2>QuizExam Admin</h2>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>

    <div class="container">

        <h1>Create New Exam</h1>
        <p>Fill in the details to create an exam.</p>
        <?php
    if(isset($_GET['success']))
    {
        echo "<p style='color: green;'>Exam Created Successfully!</p>";
    }
    ?>

        <form action="../../controllers/examControl.php" method="POST">

            <label>Exam Title</label>
            <input type="text" name="title"
                   placeholder="Enter exam title" required>

            <label>Description</label>
            <textarea name="description"
                      placeholder="Enter exam description"></textarea>

            <label>Duration (Minutes)</label>
            <input type="number" name="duration"
                   placeholder="Enter duration"
                   min="1" required>

            <button type="submit" name="createExam">
                Create Exam
            </button>

        </form>

    </div>

</body>
</html>