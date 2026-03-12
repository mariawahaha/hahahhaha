<?php

session_start();

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$jsonData = file_get_contents("users.json");
$data = json_decode($jsonData, true);

$inputUser = $_POST['username'];
$inputPassword = $_POST['password'];
$valid = false;

//check if user exists

foreach ($data['users'] as &$user){
    if($user['username'] === $inputUser){
        //verify hashed user
    if(password_verify($inputPassword, $user['password'])){

    //generate otp
    $otp = rand(100000, 999999);

    $user['otp'] = $otp;
    $user['otp_expiry'] = time() + 300; //5minutes expiration


    file_put_contents("users.json", json_encode($data, JSON_PRETTY_PRINT));
    $_SESSION['temp_user'] = $inputUser;

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;
    $mail->Username = 'mariellezabala17@gmail.com';
    $mail->Password = 'dhca lagm kqkn teib';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('mariellezabala17@gmail.com', 'Login Security');
    $mail->addAddress($user['email']);

    $mail->Subject = "Your OTP Code";
    $mail->Body = "Your Login OTP code is: $otp";

    try {
        $mail->send();
        header("Location: otp_verification.php");
        exit();
    } catch (Exception $e) {
        echo "Email could not be sent. Error: " . $mail->ErrorInfo;
        exit();
    }

        //$valid = true;
    
        //$_SESSION['username'] = $inputUser;
    }else{
        echo "Invalid Password.";
        exit();
    }
        break;
    }
}

//login result

    echo "Invalid username and password!";
?>