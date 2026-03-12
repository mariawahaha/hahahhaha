<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Verify OTP </h1>
    <form action = "otp_verification_process.php" method="POST">
        <label for ="otp"> Enter OTP:</label><br>
        <input type ="text" name ="otp" required><br><br>

        <button type="submit">Verify</button>
</body>
</html>