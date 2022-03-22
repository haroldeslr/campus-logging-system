<?php
session_start();
require "php/connect_to_database.php";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = "";
$username = "";
$errors = array();

// login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    //query
    $check_username = "SELECT * FROM user_tbl WHERE username = '$username'";
    //check
    $res = mysqli_query($conn, $check_username);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_password = $fetch['password'];
        $email = $fetch['email'];
        if (password_verify($password, $fetch_password)) {
            $status = $fetch['status'];
            if ($status == 'verified') {
                $_SESSION['username'] = $fetch['username'];
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['userIsLogin'] = true;
                $_SESSION['role'] = $fetch['role'];
                $_SESSION['type'] = $fetch['type'];

                header("location: dashboard.php");
                exit();
            } else {
                $info = "It's look like you haven't still verify your email - $email";
                $_SESSION['info'] = $info;
                header('location: user-otp.php');
                exit();
            }
        } else {
            $errors['login-status'] = "Incorrect username or password!";
        }
    } else {
        $errors['login-status'] = "Incorrect username or password!";
    }
}

// forgot password
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM user_tbl WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        //code generator
        $code = rand(999999, 111111);
        $insert_code = "UPDATE user_tbl SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($conn, $insert_code);
        if ($run_query) {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'campusloggingsystem3@gmail.com';                     //SMTP username  email ng gumagamit ng phpmailer (Account ko yan. pero pwede mo makita sa mysql yung code)
                $mail->Password   = 'admin123!';                               //SMTP password password ng email ko
                $mail->SMTPSecure = 'ssl';         //Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS encouraged
                $mail->Port       = 465;                                    //TCP port to connect to, use 465 for PHPMailer::ENCRYPTION_SMTPS above
                //Eto yung format ng email.
                //Recipients
                $mail->setFrom('campusloggingsystem3@gmail.com', 'Campus Logging Systen');
                $mail->addAddress($email);     //Add a recipient
                $mail->addReplyTo('campusloggingsystem3@gmail.com', 'No reply');

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Password Reset Code';
                $mail->Body    = "Your password reset code is $code";
                $mail->send();

                $info = "We've sent a passwrod reset otp to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}

// check OTP
if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM user_tbl WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

// change password with OTP
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE user_tbl SET code = $code, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if ($run_query) {
            $info = "Your password changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
            exit();
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}

// change password without OTP
if (isset($_POST['change-password-without-otp'])) {
    $currentPasswordInDB = $_SESSION['password'];
    $currentPasswordInput = mysqli_real_escape_string($conn, $_POST['current-password']);
    $newPasswordInput = mysqli_real_escape_string($conn, $_POST['new-password']);
    $confirmNewPassword = mysqli_real_escape_string($conn, $_POST['confirm-new-password']);
    if ($currentPasswordInDB !== $currentPasswordInput || $newPasswordInput !== $confirmNewPassword) {
        $errors['change-password'] = "Password not matched!";
    } else {
        $email = $_SESSION['email'];
        $encpass = password_hash($newPasswordInput, PASSWORD_BCRYPT);
        $update_pass = "UPDATE user_tbl SET password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if ($run_query) {
            $_SESSION['change-password-status'] = "Change Password Success!";
            header('Location: account-profile.php');
            exit();
        } else {
            $errors['change-password'] = "Failed to change your password!";
        }
    }
}
