<?php
require_once __DIR__. "/../config/dbConnect.php";

function saveExamResult($user_id, $exam_id, $total_questions, $correct_answers, $score)
{
    global $conn;

    $sql = "INSERT INTO results
            (user_id, exam_id, total_questions, correct_answers, score, submitted_at)
            VALUES (?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iiiid",
        $user_id,
        $exam_id,
        $total_questions,
        $correct_answers,
        $score
    );

    return mysqli_stmt_execute($stmt);
}

function getStudentResult($user_id, $exam_id)
{
    global $conn;

    $sql = "SELECT results.*, exams.title AS exam_name
            FROM results
            INNER JOIN exams ON results.exam_id = exams.id
            WHERE results.user_id = ? AND results.exam_id = ?
            ORDER BY results.id DESC
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ii", $user_id, $exam_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

function getStudentResults($user_id)
{
    global $conn;

    $sql = "SELECT results.*, exams.title AS exam_name
            FROM results
            INNER JOIN exams ON results.exam_id = exams.id
            WHERE results.user_id = ?
            ORDER BY results.id DESC";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $user_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return $result;
}