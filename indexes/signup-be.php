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

// check if the fields in fignup form are set
if (
    isset($_POST['register'])
) {
    function validate($data) // this function will be used to clean and validate user input
    {
        $data = trim($data); // this will trim the white spaces of both end of user's input
        $data = stripslashes($data); // this will eliminate all backslashes of user's input
        $data = htmlspecialchars($data);// it will convert characters to their corresponding HTML entities
        return $data;
    }

    $lname = validate($_POST['lastname']); //assign the processed lastname to the cariable $lname
    $fname = validate($_POST['firstname']);//assign the processed firstname to the cariable $fname
    $mname = validate($_POST['middlename']);//assign the processed middlename to the cariable $mname
    $uname = validate($_POST['uname']);//assign the processed uname to the cariable $uname
    $email = validate($_POST['email']);//assign the processed email to the cariable $email
    $pass = validate($_POST['password']);//assign the processed password to the cariable $pass
    $repass = validate($_POST['repassword']);//assign the processed repassword to the cariable $repass
    $tandc =  $_POST['tandc'];

    $user_data = 'lname='. $lname. '&fname='. $fname . '&mname='. $mname . '&uname='. $uname . '&email='. $email; 

    /****************************** Checking signup credentials ******************************/
    if(empty($lname)){
        header("Location: ../register-v2.php?error=Lastname is required&$user_data");
	    exit();
	}else if(empty($fname)){
        header("Location: ../register-v2.php?error=Firstname is required&$user_data");
	    exit();
	}elseif (empty($uname)) {
		header("Location: ../register-v2.php?error=User Name is required&$user_data");
	    exit();
	}else if(empty($email)){
        header("Location: ../register-v2.php?error=Email is required&$user_data");
	    exit();
	}else if(empty($pass)){
        header("Location: ../register-v2.php?error=Password is required&$user_data");
	    exit();
	}else if(empty($repass)){
        header("Location: ../register-v2.php?error=Re Password is required&$user_data");
	    exit();
	}else if(empty($tandc)){
        header("Location: ../register-v2.php?error=You must agree with terms and condition&$user_data");
	    exit();
	}elseif ($pass !== $repass) {
        header("Location: ../register-v2.php?error=Password does not match.");// this will prompt if the password and repassword 
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE username='$uname'";// this SQL query use to select all records from the user table where the username matches the submitted uname
        $result = mysqli_query($conn, $sql); // it execute the SQL query and store the result in the variable result

        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);// it will hash the password using BYCRYP algorithm and store the hashed password in the variable $hashed_pass

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../register-v2.php?error=Username is already taken.&$user_data");// this error will prompt when the input username was already registered 
            exit();
        } else {
            $sql_email = "SELECT * FROM user WHERE email='$email'"; // this SQL query use to select all records from the user table where the Email matches the submitted email
            $result_email = mysqli_query($conn, $sql_email);

            if (mysqli_num_rows($result_email) > 0) {
                header("Location: ../register-v2.php?error=Email address is already registered.&$user_data"); // this error will prompt when the input email was already registered 
                exit();
            } else {
                $v_code = rand(100000, 999999); // it will generate random 6 digit number
                // this SQL query will use to insert new data into 'user' table with the submitted information
                $sql2 = "INSERT INTO user(username, password, Lastname, First_name, Middle_name, Email, verification_code, is_verified) 
                         VALUES ('$uname', '$hashed_pass', '$lname', '$fname', '$mname', '$email', '$v_code', '0')";
                $result2 = mysqli_query($conn, $sql2);


                if ($result2 && sendMail($_POST['email'], $v_code)) {
                    // it will redirect user to creattedsuccessfully page 
                    $_SESSION['verify'] = true;
                    $_SESSION['email'] = $email;// it used to automatically fill the email address input
                    header("Location: ../createdsuccessfully.php?success=Your account has been registered. To successfully created, please check your registered email address.");
                    exit();
                } else {
                    // this will prompt  an error message when there is a problem with sending verification mail or inserting data to the table
                    header("Location: ../register-v2.php?error=Unknown error occurred.");
                    exit();
                }

            }

        }
    }
} else {
    header("Location: ../register-v2.php");
    exit();
}
?>