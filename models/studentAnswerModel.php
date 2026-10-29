<?php
require_once __DIR__. "/../config/dbConnect.php";

function saveStudentAnswer($user_id, $exam_id, $question_id, $selected_answer)
{
    global $conn;

    $sql = "INSERT INTO student_answers
            (user_id, exam_id, question_id, selected_answer)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iiis",
        $user_id,
        $exam_id,
        $question_id,
        $selected_answer
    );

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}