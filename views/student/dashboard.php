<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student')
{
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
     <link rel="stylesheet" href="../css/studentDashboard.css?v=1">
</head>
<body>

    <h1>Student Dashboard</h1>

    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h2>

    <a href="availableExams.php">Available Exams</a>
    <br><br>

    <a href="myResults.php">My Results</a>
    <br><br>

    <a href="../logout.php">Logout</a>

</body>
</html>