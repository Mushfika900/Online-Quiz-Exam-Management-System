<?php

require_once __DIR__. "/../config/dbConnect.php";

function createExam($title, $description, $duration)
{
    global $conn;

    $sql = "INSERT INTO exams (title, description, duration)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $duration);

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}

function getAllExams()
{
    global $conn;

    $sql = "SELECT * FROM exams ORDER BY id DESC";

    $result = mysqli_query($conn, $sql);

    return $result;
}
function getExamById($id)
{
    global $conn;

    $sql = "SELECT * FROM exams WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $exam = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $exam;
}

?>