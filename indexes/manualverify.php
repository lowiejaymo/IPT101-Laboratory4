<?php
require('db_conn.php');

if (isset($_POST['email']) && isset($_POST['v_code'])) {
    $email = $_POST['email'];
    $v_code = $_POST['v_code'];

     // if verification code is missing or blank
    if (empty($v_code)) {
        header("Location: ../createdsuccessfully.php?error=Verification code is missing.");
        exit();
    }

    // Using prepared statement to prevent SQL injection
    $query = "SELECT * FROM `user` WHERE `Email` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) { // if email is existing in the database
        $row = mysqli_fetch_assoc($result);
        if ($row['verification_code'] == $v_code) {// checking if the entered verification code matched with the verification code stored in the database
            if ($row['is_verified'] == 0) { // checking if the 'is_verified' column has a value of 0, if 0 means it is not verified, if 1 then it is verified
                // Update the verification status in the database
                $update = "UPDATE user SET is_verified='1' WHERE Email = ?";
                $stmt = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($stmt, "s", $email);
                if (mysqli_stmt_execute($stmt)) { // this alert will promt when  update is successfull updated or verified the 
                    header("Location: ../login-v2.php?success=Email verification successful.");
                    exit();
                } else {// this alert will promt when  update is unsuccessfull updated or unverified the user
                    header("Location: ../createdsuccessfully.php?error=Unknown error occurred.");
                    exit();
                }
            } else {// this will prompt when user attempt to verify a verified account
                header("Location: ../login-v2.php?success=Email Address was already registered");
                exit();
            }
        } else {// this will prompt if the input verification code was not  match with the one stored on the datdatabase
            header("Location: ../createdsuccessfully.php?error=Verification code is incorrect.");
            exit();
        }
    } else {// this will prompt if the input email was not  match with the one stored on the datdatabase
        header("Location: ../createdsuccessfully.php?error=Email Address not found or incorrect.");
        exit();
    }
} else {// Handle case where email or verification code is not provided
    header("Location: ../createdsuccessfully.php?error=Email or verification code is missing.");
    exit();
}