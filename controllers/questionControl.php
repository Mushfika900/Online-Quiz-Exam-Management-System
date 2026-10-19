<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../views/login.php");
    exit();
}

require_once "../models/questionModel.php";
require_once "../models/examModel.php";

if(isset($_POST['addQuestion']))
{
    $exam_id = $_POST['exam_id'];
    $question = trim($_POST['question']);
    $option_a = trim($_POST['option_a']);
    $option_b = trim($_POST['option_b']);
    $option_c = trim($_POST['option_c']);
    $option_d = trim($_POST['option_d']);
    $correct_answer = $_POST['correct_answer'];

    if($question == "" || $option_a == "" ||
       $option_b == "" || $option_c == "" ||
       $option_d == "" || $correct_answer == "")
    {
        echo "All fields are required";
    }
    else if(!ctype_digit($exam_id) || (int)$exam_id <= 0)
    {
        echo "Invalid Exam ID";
    }
    else if($correct_answer != 'A' &&
            $correct_answer != 'B' &&
            $correct_answer != 'C' &&
            $correct_answer != 'D')
    {
        echo "Invalid Correct Answer";
    }
    else
    {
        $exam = getExamById((int)$exam_id);

        if(!$exam || $exam['status'] != 'active')
        {
            echo "Please select an active exam";
        }
        else
        {
            $result = addQuestion(
                (int)$exam_id,
                $question,
                $option_a,
                $option_b,
                $option_c,
                $option_d,
                $correct_answer
            );

            if($result)
            {
                header("Location:../views/admin/addQuestion.php?success=1");
                exit();
            }
            else
            {
                echo "Question Add Failed";
            }
        }
    }
}

if (isset($_POST['updateQuestion'])) {

    $id = (int) ($_POST['id'] ?? 0);
    $question = trim($_POST['question'] ?? '');
    $option_a = trim($_POST['option_a'] ?? '');
    $option_b = trim($_POST['option_b'] ?? '');
    $option_c = trim($_POST['option_c'] ?? '');
    $option_d = trim($_POST['option_d'] ?? '');
    $correct_answer = strtoupper(trim($_POST['correct_answer'] ?? ''));

    if (
        $id <= 0 ||
        $question === '' ||
        $option_a === '' ||
        $option_b === '' ||
        $option_c === '' ||
        $option_d === ''
    ) {
        die("All fields are required");
    }

    if (!in_array($correct_answer, ['A', 'B', 'C', 'D'], true)) {
        die("Invalid Correct Answer");
    }

    if (!getQuestionById($id)) {
        die("Question not found");
    }

    $result = updateQuestion(
        $id,
        $question,
        $option_a,
        $option_b,
        $option_c,
        $option_d,
        $correct_answer
    );

    if ($result) {
        header("Location: ../views/admin/manageQuestion.php?updated=1");
        exit();
    } else {
        echo "Question Update Failed";
    }
}

?>