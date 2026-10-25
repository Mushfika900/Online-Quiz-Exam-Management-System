<?php
session_start();
require_once __DIR__."/../models/questionModel.php";

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

echo "Total Questions: " . $total_questions;
echo "<br>";
echo "Correct Answers: " . $correct_answers;
echo "<br>";
echo "Score: " . round($score, 2) . "%";
}
?>