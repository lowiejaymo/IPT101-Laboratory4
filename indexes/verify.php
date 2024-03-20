<?php
require('db_conn.php'); // Include the database script to establish a connection with the database

if(isset($_GET['email']) && isset($_GET['v_code'])){
    // Query to check if the provided email and verification code match using prepared statement
    $query = "SELECT * FROM `user` WHERE `Email` = ? AND `verification_code`= ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ss", $_GET['email'], $_GET['v_code']);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    if($result){
        if(mysqli_num_rows($result) == 1){ // If email exists in the database
            $result_fetch = mysqli_fetch_assoc($result);
            if($result_fetch['is_verified'] == 0){ // If the account is not verified
                // Update the verification status in the database using prepared statement
                $update_query = "UPDATE user SET is_verified='1' WHERE Email = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);

                // Bind parameter to the prepared statement
                mysqli_stmt_bind_param($update_stmt, "s", $result_fetch['Email']);

                // Execute the prepared statement to update verification status
                if(mysqli_stmt_execute($update_stmt)){ // If update is successful
                    header("Location: ../login-v2.php?success=Email verification successful.");
                    exit();
                } else { // If update fails
                    header("Location: ../login-v2.php?error=Unknown error occurred.");
                    exit();
                }
            } else { // If the account is already verified
                header("Location: ../login-v2.php?error=Email Address was already registered");
                exit();
            }
        }
    } else { // If data was not found in the database
        header("Location: ../login-v2.php?error=Unknown error occurred.");
        exit();
    }
}
?>
