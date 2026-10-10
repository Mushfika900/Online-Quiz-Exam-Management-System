<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="css/registration.css">
</head>
<body>

    <h2>Student Registration</h2>

    <form action="../controllers/registrationControl.php" method="POST">

        <label>Full Name:</label>
        <input type="text" name="name" required>
        <br><br>

        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br><br>

        <input type="submit" name="register" value="Register">

    </form>

    <p class="login-link">
    Already have an account?
    <a href="login.php">Login Here</a>
    </p>
</body>
</html>