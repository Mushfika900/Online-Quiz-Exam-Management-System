<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Exam System</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

    <div class="login-container">

        <h2>Welcome Back!</h2>
        <p>Login to your account</p>

        <form action="../controllers/loginControl.php" method="POST">

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit" name="login">Login</button>

        </form>

        <p>
            Don't have an account?
            <a href="registration.php">Register Here</a>
        </p>

    </div>

</body>
</html>