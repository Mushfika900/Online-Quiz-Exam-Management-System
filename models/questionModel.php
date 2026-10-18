<?php

require_once __DIR__."/../config/dbConnect.php";

function addQuestion($exam_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer)
{
    global $conn;

    $sql = "INSERT INTO questions
            (exam_id, question, option_a, option_b, option_c, option_d, correct_answer)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "issssss",
        $exam_id,
        $question,
        $option_a,
        $option_b,
        $option_c,
        $option_d,
        $correct_answer
    );

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}

function getAllQuestions()
{
    global $conn;
    $sql = "SELECT questions.*, exams.title AS exam_name
        FROM questions
        INNER JOIN exams
        ON questions.exam_id = exams.id
        ORDER BY questions.id DESC";

    $result = mysqli_query($conn, $sql);

    return $result;
}

?>