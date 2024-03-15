<?php  
require('db_conn.php');// include the database script to establish a connection with the database

if(isset($_GET['email']) && isset($_GET['v_code'])){

    // Query to check if the provided email and verification code match
    $query = "SELECT * FROM `user` WHERE `Email` = '$_GET[email]' AND `verification_code`= '$_GET[v_code]'";

    $result = mysqli_query($conn, $query);  // execute the query and store

    if($result){
        if(mysqli_num_rows($result) == 1){ // if email is existing in the database
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['is_verified']==0){ // checking if the 'is_verified' column has a value of 0, if 0 means it is not verified, if 1 then it is verified
               // Update the verification status in the database
                $update ="UPDATE user SET is_verified='1' WHERE Email = '$result_fetch[Email]'"; 
                if(mysqli_query($conn, $update)){ // this alert will promt when  update is successfull updated or verified the user
                    header("Location: ../login-v2.php?success=Email verification successful.");
                exit();
                } else{ // this alert will promt when  update is unsuccessfull updated or unverified the user account
                    header("Location: ../login-v2.php?error=Unkown error occured.");
                exit();
                }
            }else{ // this will prompt when user attempt to verify a verified account
                header("Location: ../login-v2.php?error=Email Address was already registered");
                exit();
            }
        }
    } else { // this will prompt when the data was not found in the database
        header("Location: ../login-v2.php?error=Unkown error occured.");
                exit();
    }
}
