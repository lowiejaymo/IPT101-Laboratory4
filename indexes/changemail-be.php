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

    $code_input = 'request_code_data=' . $requestCode;

    // Check if new email is not empty or blank
    if (empty($newEmail) || trim($newEmail) === "") {
        header("Location: ../profile.php?requestcodeerror=New email address is empty");
        exit();
    }

    // Check if new email is already exixting
    $checkNewEmailQuery = "SELECT * FROM user WHERE username = ? AND new_email = ?";
    $checkNewEmailStmt = mysqli_prepare($conn, $checkNewEmailQuery);
    mysqli_stmt_bind_param($checkNewEmailStmt, "ss", $username, $newEmail);
    mysqli_stmt_execute($checkNewEmailStmt);
    $checkNewEmailresult = mysqli_stmt_get_result($checkNewEmailStmt);

    if (empty($requestCode)) {
        //checks if the request code input was empty
        header("Location: ../profile.php?requestcodeerror=Verification Code is required&$code_input");
        exit();
    } elseif (empty($password)) {
        //checks if the password input was empty
        header("Location: ../profile.php?requestcodeerror=Password is required&$code_input");
        exit();
    } elseif (!password_verify($password, $stored_password)) { 
        //checks if the input password is match with the stored password
        header("Location: ../profile.php?requestcodeerror=Incorrect Password");
        exit();
    } else {
        // Check if verification code matches
        $sql = "SELECT * FROM user WHERE Email = ? AND verification_code = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $currentEmail, $requestCode);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) { 
            //checking if the verification code input match with with stored code using the query above
            header("Location: ../profile.php?requestcodeerror=Verification Code is incorrect");
            exit();
        } else {
            if (mysqli_num_rows($checkNewEmailresult) == 0) {
                // if the email is already existing
                header("Location: ../profile.php?requestcodeerror=Email Address is already existing");
                exit();
            }

            // Verification successful, update email in the database
            $updateSql = "UPDATE user SET Email = ? WHERE username = ?";
            $updateStmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, "ss", $newEmail, $username);
            if (mysqli_stmt_execute($updateStmt)) {
                $updateSql2 = "UPDATE user SET new_email = '' WHERE username = ?";
                $updateStmt2 = mysqli_prepare($conn, $updateSql2);
                mysqli_stmt_bind_param($updateStmt2, "s", $username);
                mysqli_stmt_execute($updateStmt2);

                //updating the sessions
                $_SESSION['email'] = $newEmail;
                $_SESSION['new_email'] = "";
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
