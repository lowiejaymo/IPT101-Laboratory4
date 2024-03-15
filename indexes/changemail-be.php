<?php
require('db_conn.php');
session_start();

if (isset($_POST['change_email_password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Validate and sanitize input
    $requestCode = validate($_POST['request_code']);
    $password = validate($_POST['change_email_password']);
    $currentEmail = $_SESSION['email']; 
    $username = $_SESSION['username']; 
    $newEmail = $_SESSION['new_email']; 

    $stored_password = $_SESSION['password']; 

    $user_data = 'request_code_data='. $requestCode;

    $checkNewEmail = "SELECT * FROM user WHERE username = '$username' AND new_email = '$newEmail'";
    $checkNewEmailresult = mysqli_query($conn, $checkNewEmail);

    if(empty($requestCode)){
        header("Location: ../profile.php?requestcodeerror=Verification Code is required&$user_data");
        exit();
    } elseif(empty($password)){
        header("Location: ../profile.php?requestcodeerror=Password is required&$user_data");
        exit();
    } else if (!password_verify($password, $stored_password)) {
        header("Location: ../profile.php?requestcodeerror=Incorrect Password");
        exit();
    } else {
        // Check if verification code matches
        $sql = "SELECT * FROM user WHERE Email = '$currentEmail' AND verification_code = '$requestCode'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            header("Location: ../profile.php?requestcodeerror=Verification Code is incorrect");
            exit();
        } else {
            // Check if new email is not empty or blank
            if(empty($newEmail) || trim($newEmail) == '' || mysqli_num_rows($checkNewEmailresult) == 0) {
                header("Location: ../profile.php?requestcodeerror=New email is required");
                exit();
            }
            
            // Verification successful, update email in the database
            $updateSql = "UPDATE user SET Email = '$newEmail' WHERE username = '$username'";
            if (mysqli_query($conn, $updateSql)) {
                $updateSql2 = "UPDATE user SET new_email = '' WHERE username = '$username'";
                mysqli_query($conn, $updateSql2);
                
                $_SESSION['email'] = $newEmail;
                header("Location: ../profile.php?sencodesuccess=Email updated successfully");
                exit();
            } else {
                header("Location: ../profile.php?requestcodeerror=Failed to update email");
                exit();
            }
        }
    }
} else {
    header("Location: ../profile.php");
    exit();
}
