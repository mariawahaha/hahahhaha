<?php

session_start();

$jsonData = file_get_contents("users.json");
$data = json_decode($jsonData, true);

$inputOTP = $_POST['otp'];
$username = $_SESSION['temp_user'];

//verification process

foreach($data['users'] as $user){
    if($user['username'] === $username){
        if(time() > $user['otp_expiry']){
            die("OTP already expired!");

        }

        if($user['otp'] == $inputOTP){
            $_SESSION['username'] = $username;
            unset($_SESSION['temp_user']);
           
            header("Location: dashboard.php");
            exit();
        }else{
            echo "OTP is invalid.";
            exit();
        }
    }

}
?>