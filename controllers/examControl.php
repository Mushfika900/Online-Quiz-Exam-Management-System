<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../views/login.php");
    exit();
}

require_once __DIR__. "/../models/examModel.php";

if(isset($_POST['createExam']))
{
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $duration = trim($_POST['duration']);

    if(empty($title) || empty($duration))
    {
        echo "Title and Duration are required";
    }
    else if(strlen($title) > 150)
    {
        echo "Exam Title is too long";
    }
    else if(!ctype_digit($duration) || (int)$duration < 1)
    {
        echo "Enter a valid Duration";
    }
    else
    {
        $result = createExam($title, $description, (int)$duration);

        if($result)
        {
            header("Location: ../views/admin/createExam.php?success=1");
            exit();
        }
        else
        {
            echo "Exam Creation Failed";
        }
    }
}
if(isset($_POST['updateExam']))
{
    $id = (int)$_POST['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $duration = trim($_POST['duration']);
    $status = $_POST['status'];

    if($id <= 0 || empty($title) || $duration == '')
    {
        echo "All required fields must be filled";
    }
    else if(strlen($title) > 150)
    {
        echo "Exam Title is too long";
    }
    else if(!ctype_digit($duration) || (int)$duration < 1)
    {
        echo "Enter a valid Duration";
    }
    else if($status != 'active' && $status != 'inactive')
    {
        echo "Invalid Exam Status";
    }
    else
    {
        $result = updateExam($id, $title, $description, (int)$duration, $status);

        if($result)
        {
            header("Location: ../views/admin/manageExam.php?updated=1");
            exit();
        }
        else
        {
            echo "Exam Update Failed";
        }
    }
}

if(isset($_POST['deleteExam']))
{
    $id = (int)$_POST['id'];

    if($id <= 0)
    {
        echo "Invalid Exam ID";
    }
    else
    {
        $exam = getExamById($id);

    if(!$exam)
{
    echo "Exam Not Found";
}
else if(hasExamData($id))
{
    echo "Cannot Delete! This Exam has related data.";
}
else
{
    $result = deleteExam($id);

    if($result)
    {
        header("Location: ../views/admin/manageExam.php?deleted=1");
        exit();
    }
    else
    {
        echo "Exam Delete Failed";
    }
}
    }
}

?>