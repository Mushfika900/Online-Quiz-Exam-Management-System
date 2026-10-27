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
    <title>Student Dashboard</title>
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