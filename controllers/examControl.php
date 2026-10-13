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

?>