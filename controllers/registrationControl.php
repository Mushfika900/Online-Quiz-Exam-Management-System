<?php

require_once "../models/userModel.php";

if(isset($_POST['register']))
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if(empty($name) || empty($email) || empty($password))
    {
        echo "All fields are required";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "Invalid email address";
    }
    else if($password != $confirmPassword)
    {
        echo "Passwords do not match";
    }
    else if(checkEmail($email))
    {
        echo "Email already exists";
    }
    else
    {
        $result = registerStudent($name, $email, $password);

        if($result)
        {
            header("Location:../views/login.php");
            exit();
        }
        else
        {
            echo "Registration Failed";
        }
    }
}

?>