<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Register</h2><br>

    <form action="process_register.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" require><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" require><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" require><br><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" name="confirm_password" require><br><br>

        <button type="submit">Register</button>

    </form>

    <h6>Already have an account?<a href="login.php">Login</a></h6>

</body>
</html>