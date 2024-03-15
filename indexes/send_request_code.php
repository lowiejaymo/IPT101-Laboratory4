<?php

require('db_conn.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//this function use for sending verification button and verification code
function sendMail($newEmail, $verificationCode, $username)
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

        $mail->setFrom('lowiejayorillolaboratory@gmail.com', 'Email Change Request Code | ORILLO IPT101 LABORATORY');
        $mail->addAddress($newEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Email Change Request Code from ORILLO IPT101 LABORATORY';
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
                <h1>Hello, $username!</h1>
                <h3>Your request code to change your email address has been generated. Below is your request code.</h3>
                <h3> Request Code: $verificationCode</h3>
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

if (isset($_POST['send_code'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate and sanitize input
    $newEmail = validate($_POST['new_email']);
    $currentEmail = $_SESSION['email']; 
    $username = $_SESSION['username']; 

    $user_data = 'new_email_data='. $newEmail;

    if($newEmail == $currentEmail){
        header("Location: ../profile.php?sencodeerror=You cannot use your current email address as your new email address&$user_data");
        exit();
    }

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM user WHERE Email = '$newEmail'";
    $result = mysqli_query($conn, $checkEmailQuery);
    if (mysqli_num_rows($result) > 0) {
        header("Location: ../profile.php?sencodeerror=Email address is already taken. Please try again with a different email address&$user_data");
        exit();
    }

    // Generate random 6 digit verification code
    $verificationCode = rand(100000, 999999);

    // Update user table with verification code
    // Update user table with new email and verification code
    $updateQuery = "UPDATE user SET new_email = '$newEmail', verification_code = '$verificationCode' WHERE email = '$currentEmail'";

    if (mysqli_query($conn, $updateQuery) && sendMail($newEmail, $verificationCode, $username)) {
        // Redirect user back to profile page
        $_SESSION['new_email'] = $newEmail;
        header("Location: ../profile.php?sencodesuccess=Your request code has been sent to your new email address&$user_data");
        exit();
    } else {
        $_SESSION['message'] = "Error updating record: " . mysqli_error($conn);
        header("Location: ../profile.php?sencodeerror=Unknown error occurred");
        exit();
    }
} else {
    header("Location: ../profile.php");
    exit();
}
?>
