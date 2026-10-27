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