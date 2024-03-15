<?php

require('db_conn.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//this function use for sending verification button and verification code
function sendMail($email, $v_code)
{
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lowiejayorillolaboratory@gmail.com';
        $mail->Password = 'kscu rsfy rupo qvtg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('lowiejayorillolaboratory@gmail.com', 'Account New Verification Code | ORILLO IPT101 LABORATORY');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Account Verification from ORILLO IPT101 LABORATORY';
        $mail->Body = "
        <html>
        <head>
            <style>
                /* Add your CSS styles here */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    color: #333;
                }
                p {
                    color: #666;
                }
                a {
                    text-decoration: none;
                    color: #111;
                }
                .button {
                    display: inline-block;
                    background-color: #111111;
                    color: #ffffff;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 5px;
                } 
                
                .button:hover {
                    background-color: #808080; 
                }
            </style>
        </head>
        <body>
            <div class='container'>
            <h1>New Verification Code!</h1>
            <h3>Thank you for registering with us. To finalize your account setup, please verify your account using the following verification code:</h3>
            <h3> New Verification Code: $v_code</h3>
            <hr>
            <p>Thank you</p>
            </div>
        </body>
        </html>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['resend'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Generate a random 6-digit verification code
    $v_code = rand(100000, 999999);

    // Update the user table with the new verification code
    $sql = "UPDATE user SET verification_code = '$v_code' WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && sendMail($_POST['email'], $v_code)) {
        // Redirect with success message
        header("Location: ../createdsuccessfully.php?newsuccess=Your new Verification Code has been sent to your email.");
        exit();
    } else {
        // Redirect with error message
        header("Location: ../createdsuccessfully.php?newerror=Your new Verification Code failed to sent to your email.");
        exit();
    }
} else {
    // Redirect to a relevant page if the 'resend_code' parameter is not set
    header("Location: ../createdsuccessfully.php");
    exit();
}

// && sendMail($_POST['email'], $v_code)
