<?php

require_once "../config/dbConnect.php";

function registerStudent($name, $email, $password)
{
    global $conn;

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role, created_at)
            VALUES (?, ?, ?, 'student', NOW())";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $result;
}

function checkEmail($email)
{
    global $conn;

    $sql = "SELECT id FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_store_result($stmt);

    $count = mysqli_stmt_num_rows($stmt);

    mysqli_stmt_close($stmt);

    if($count > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function loginUser($email, $password)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if($user && password_verify($password, $user['password']))
    {
        return $user;
    }
    else
    {
        return false;
    }
}

?>