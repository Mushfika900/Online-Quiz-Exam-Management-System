<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <div class="header">
        <div class="logo">Quiz Exam Admin</div>

        <a href="../logout.php" class="logout">Logout</a>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>
                Welcome Back,
                <?php echo htmlspecialchars($_SESSION['name']); ?>!
            </h1>

            <p>Manage your online exams and student results.</p>
        </div>

        <h2>Exam Management</h2>

        <div class="cards">

            <a href="createExam.php" class="card">
                <h3>Create Exam</h3>
                <p>Create new online exams</p>
            </a>

            <a href="manageExam.php" class="card">
                <h3>Manage Exams</h3>
                <p>View and manage all exams</p>
            </a>

            <a href="manageQuestion.php" class="card">
                <h3>Manage Questions</h3>
                <p>Add and update MCQ questions</p>
                
            </a>
           

            <a href="#" class="card">
                <h3>View Results</h3>
                <p>Check student exam results</p>
            </a>

        </div>

    </div>

</body>
</html>