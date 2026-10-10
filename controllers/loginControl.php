<?php

session_start();

require_once "../models/userModel.php";

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password))
    {
        echo "All fields are required";
    }
    else
    {
        $user = loginUser($email, $password);

        if($user)
{
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    if($user['role'] == 'admin')
    {
        header("Location: ../views/admin/dashboard.php");
        exit();
    }
    else if($user['role'] == 'student')
    {
        header("Location: ../views/student/dashboard.php");
        exit();
    }
    else
    {
        echo "Invalid User Role";
    }
}
else
{
    echo "Invalid Email or Password";
}
}
}

?>