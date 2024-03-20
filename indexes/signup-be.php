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

        $mail->setFrom('lowiejayorillolaboratory@gmail.com', 'Account Verification | ORILLO IPT101 LABORATORY');
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
                <h1>Thank you for signing up!</h1>
                <h3>Thank you for registering with us. To finalize your account setup, please verify your account using the following verification code:</h3>
                <h3> Verification Code: $v_code</h3>
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


// Check if the 'register' button is clicked
if (isset($_POST['register'])) {
    // Function to validate and sanitize user input
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate and sanitize input fields
    $lname = validate($_POST['lastname']);
    $fname = validate($_POST['firstname']);
    $mname = validate($_POST['middlename']);
    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);
    $repass = validate($_POST['repassword']);
    $tandc = isset($_POST['tandc']);

     // Prepare user data for redirection in case of validation errors
     $user_data = 'lname='. $lname. '&fname='. $fname . '&mname='. $mname . '&uname='. $uname . '&email='. $email; 

     // Checking signup credentials
     if(empty($lname)){
         //checks if the Last name was empty
         header("Location: ../register-v2.php?error=Lastname is required&$user_data");
         exit();
     }elseif(empty($fname)){
         //checks if the First name was empty
         header("Location: ../register-v2.php?error=Firstname is required&$user_data");
         exit();
     }elseif (empty($uname)) {
         //checks if the unsername was empty
         header("Location: ../register-v2.php?error=User Name is required&$user_data");
         exit();
     }elseif(empty($email)){
         //checks if the email was empty
         header("Location: ../register-v2.php?error=Email is required&$user_data");
         exit();
     }elseif(empty($pass)){
         //checks if the password was empty
         header("Location: ../register-v2.php?error=Password is required&$user_data");
         exit();
     }elseif(empty($repass)){
         //checks if the retype password was empty
         header("Location: ../register-v2.php?error=Re Password is required&$user_data");
         exit();
     }elseif(empty($tandc)){
         //checks if the terms and condition was uncheck
         header("Location: ../register-v2.php?error=You must agree with terms and condition&$user_data");
         exit();
     }elseif ($pass !== $repass) {
         //checks if the password and retype password match
         header("Location: ../register-v2.php?error=Password does not match.");// this will prompt if the password and repassword 
         exit();
     } else {
        // Check if the username is already taken using prepared statement
        $sql = "SELECT * FROM user WHERE username=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // If username is already taken, redirect with error message
            header("Location: ../register-v2.php?error=Username is already taken.&$user_data");
            exit();
        } else {
            // Check if the email is already registered using prepared statement
            $sql_email = "SELECT * FROM user WHERE email=?";
            $stmt_email = mysqli_prepare($conn, $sql_email);
            mysqli_stmt_bind_param($stmt_email, "s", $email);
            mysqli_stmt_execute($stmt_email);
            $result_email = mysqli_stmt_get_result($stmt_email);

            if (mysqli_num_rows($result_email) > 0) {
                // If email is already registered, redirect with error message
                header("Location: ../register-v2.php?error=Email address is already registered.&$user_data");
                exit();
            } else {
                $v_code = rand(100000, 999999); // Generate random 6 digit number

                // Insert user data into 'user' table using prepared statement
                $hashed_pass = password_hash($pass, PASSWORD_BCRYPT); // Hash the password for security
                $sql2 = "INSERT INTO user(username, password, Lastname, First_name, Middle_name, Email, verification_code, is_verified) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, '0')";
                $stmt2 = mysqli_prepare($conn, $sql2);
                mysqli_stmt_bind_param($stmt2, "sssssss", $uname, $hashed_pass, $lname, $fname, $mname, $email, $v_code);
                $result2 = mysqli_stmt_execute($stmt2);

                if ($result2 && sendMail($_POST['email'], $v_code)) {
                    // If registration is successful, set session variables and redirect to success page
                    $_SESSION['verify'] = true;
                    $_SESSION['email'] = $email;
                    header("Location: ../createdsuccessfully.php?success=Your account has been registered. To successfully created, please check your registered email address.");
                    exit();
                } else {
                    // If there is an error, redirect with error message
                    header("Location: ../register-v2.php?error=Unknown error occurred.");
                    exit();
                }
            }
        }
    }
} else {
    // If 'register' button is not clicked, redirect to registration page
    header("Location: ../register-v2.php");
    exit();
}
?>
