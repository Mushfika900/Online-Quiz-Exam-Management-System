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

function getQuestionById($id)
{
    global $conn;

    $id = (int) $id;

    $sql = "SELECT * FROM questions WHERE id = $id";

    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

function updateQuestion($id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer)
{
    global $conn;

    $sql = "UPDATE questions SET
            question = ?,
            option_a = ?,
            option_b = ?,
            option_c = ?,
            option_d = ?,
            correct_answer = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssi",
        $question,
        $option_a,
        $option_b,
        $option_c,
        $option_d,
        $correct_answer,
        $id
    );

    return mysqli_stmt_execute($stmt);
}

function deleteQuestion($id)
{
    global $conn;

    $sql = "DELETE FROM questions WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}

?>