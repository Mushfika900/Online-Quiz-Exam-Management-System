<?php
session_start();
require_once __DIR__."/../config/dbConnect.php";
require_once __DIR__."/../models/questionModel.php";
require_once __DIR__."/../models/resultModel.php";
require_once __DIR__."/../models/studentAnswerModel.php";


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../views/login.php");
    exit();
}

if (isset($_POST['submitExam'])) {

    $user_id = $_SESSION['user_id'];

    $exam_id = (int)($_POST['exam_id'] ?? 0);

    $answers = $_POST['answer'] ?? [];

    if ($exam_id <= 0 || !is_array($answers)) {
        die("Invalid Exam Submission");
    }

    if (!isset($_SESSION['exam_end_times'][$exam_id])) {
    die("Exam session not found.");
}

$endTime = $_SESSION['exam_end_times'][$exam_id];

if (time() > $endTime + 10) {
    die("Exam time is over. Submission not allowed.");
}

    $questions = getQuestionsByExamId($exam_id);

$total_questions = 0;
$correct_answers = 0;

while ($row = mysqli_fetch_assoc($questions)) {

    $total_questions++;

    $question_id = $row['id'];
    $correct_answer = $row['correct_answer'];

    if (isset($answers[$question_id])) {

        if ($answers[$question_id] == $correct_answer) {
            $correct_answers++;
        }

    }
}

if ($total_questions == 0) {
    die("No questions found for this exam.");
}

$score = ($correct_answers / $total_questions) * 100;


$sql = "SELECT id FROM results
        WHERE user_id = ? AND exam_id = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $exam_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    die("You have already submitted this exam.");
}

mysqli_stmt_close($stmt);


$result = saveExamResult(
    $user_id,
    $exam_id,
    $total_questions,
    $correct_answers,
    $score
);

if ($result) {

    $questions = getQuestionsByExamId($exam_id);

    while ($row = mysqli_fetch_assoc($questions)) {

        $question_id = $row['id'];

        if (isset($answers[$question_id])) {

            $selected_answer = $answers[$question_id];

            saveStudentAnswer(
                $user_id,
                $exam_id,
                $question_id,
                $selected_answer
            );
        }
    }

    header("Location: ../views/student/result.php?exam_id=" . $exam_id);
    exit();

} else {
    echo "Exam submission failed";
}
}
?>