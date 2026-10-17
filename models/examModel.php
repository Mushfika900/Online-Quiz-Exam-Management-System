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
function updateExam($id, $title, $description, $duration, $status)
{
    global $conn;

    $sql = "UPDATE exams
            SET title = ?, description = ?, duration = ?, status = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssisi",
        $title, $description, $duration, $status, $id);

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}

function deleteExam($id)
{
    global $conn;

    $sql = "DELETE FROM exams WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}

function hasExamData($id)
{
    global $conn;

    $sql = "SELECT
        (SELECT COUNT(*) FROM questions WHERE exam_id = ?) AS total_questions,
        (SELECT COUNT(*) FROM results WHERE exam_id = ?) AS total_results,
        (SELECT COUNT(*) FROM student_answers WHERE exam_id = ?) AS total_answers";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iii", $id, $id, $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if($data['total_questions'] > 0 ||
       $data['total_results'] > 0 ||
       $data['total_answers'] > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
?>