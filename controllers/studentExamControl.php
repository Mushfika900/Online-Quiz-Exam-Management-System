<?php
session_start();

require_once __DIR__. "/../config/dbConnect.php";
require_once __DIR__. "/../models/questionModel.php";
require_once __DIR__. "/../models/resultModel.php";
require_once __DIR__. "/../models/studentAnswerModel.php";

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') != 'student') {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['submitExam'])) {
    header("Location: ../views/student/availableExams.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$exam_id = (int) ($_POST['exam_id'] ?? 0);
$answers = $_POST['answer'] ?? [];

if ($exam_id <= 0 || !is_array($answers)) {
    die("Invalid Exam Submission.");
}

if (!isset($_SESSION['exam_end_times'][$exam_id])) {
    die("Exam session not found.");
}

$endTime = (int) $_SESSION['exam_end_times'][$exam_id];

if (time() > $endTime + 10) {
    die("Exam time is over. Submission not allowed.");
}

// Check previous submission
$sql = "SELECT id FROM results
        WHERE user_id = ? AND exam_id = ?
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $exam_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

$already_submitted = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

if ($already_submitted) {
    header("Location: ../views/student/result.php?exam_id=" . $exam_id);
    exit();
}

// Load exam questions
$questions = getQuestionsByExamId($exam_id);

$total_questions = 0;
$correct_answers = 0;
$selected_answers = [];

while ($row = mysqli_fetch_assoc($questions)) {
    $total_questions++;

    $question_id = (int) $row['id'];
    $correct_answer = strtoupper(trim($row['correct_answer']));

    if (isset($answers[$question_id])) {
        $selected_answer = $answers[$question_id];

        if (!is_string($selected_answer)) {
            die("Invalid answer submitted.");
        }

        $selected_answer = strtoupper(trim($selected_answer));

        if (!in_array($selected_answer, ['A', 'B', 'C', 'D'], true)) {
            die("Invalid answer submitted.");
        }

        $selected_answers[$question_id] = $selected_answer;

        if ($selected_answer === $correct_answer) {
            $correct_answers++;
        }
    }
}

if ($total_questions == 0) {
    die("No questions found for this exam.");
}

$score = ($correct_answers / $total_questions) * 100;

// Save result and answers together
mysqli_begin_transaction($conn);

try {
    $result = saveExamResult(
        $user_id,
        $exam_id,
        $total_questions,
        $correct_answers,
        $score
    );

    if (!$result) {
        throw new Exception("Result saving failed.");
    }

    foreach ($selected_answers as $question_id => $selected_answer) {
        $saved = saveStudentAnswer(
            $user_id,
            $exam_id,
            $question_id,
            $selected_answer
        );

        if (!$saved) {
            throw new Exception("Answer saving failed.");
        }
    }

    if (!mysqli_commit($conn)) {
        throw new Exception("Transaction commit failed.");
    }

    unset($_SESSION['exam_end_times'][$exam_id]);

    header("Location: ../views/student/result.php?exam_id=" . $exam_id);
    exit();

} catch (Throwable $e) {
    mysqli_rollback($conn);
    error_log("Exam submission error: " . $e->getMessage());
    die("Exam submission failed. Please try again.");
}
?>