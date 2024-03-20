<?php
session_start();

include "db_conn.php";

if (isset($_POST['login'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']); 
    $pass = validate($_POST['password']); 

    if (empty($email)) {
        //checks if the email input was empty
        header("Location: ../login-v2.php?error=Email is required");
        exit();
    } elseif (empty($pass)) {
        //checks if the password input was empty
        header("Location: ../login-v2.php?error=Password is required");
        exit();
    } else {
        // Prepare SQL statement to fetch user data by email
        $sql = "SELECT * FROM user WHERE Email=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) { 
            $row = mysqli_fetch_assoc($result);
            
            // Verify password
            if (password_verify($pass, $row['password'])) {
                // Check if the account is verified
                if ($row['is_verified'] == 1) {
                    // Prepare SQL statement to fetch user profile data
                    $sql2 = "SELECT * FROM user_profile WHERE user_id=?";
                    $stmt2 = mysqli_prepare($conn, $sql2);
                    mysqli_stmt_bind_param($stmt2, "i", $row['user_id']);
                    mysqli_stmt_execute($stmt2);
                    $result2 = mysqli_stmt_get_result($stmt2);
                    
                    if ($profile_row = mysqli_fetch_assoc($result2)) {
                        // Populate session variables
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['Lastname'] = $row['Lastname'];
                        $_SESSION['First_name'] = $row['First_name'];
                        $_SESSION['Middle_name'] = $row['Middle_name'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['email'] = $row['Email'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['new_email'] = $row['new_email']; 
                        
                        $_SESSION['phone_number'] = $profile_row['phone_number'];
                        $_SESSION['Birthday'] = $profile_row['Birthday'];
                        $_SESSION['gender'] = $profile_row['gender'];
                        $_SESSION['street_building_house'] = $profile_row['street_building_house'];
                        $_SESSION['Barangay'] = $profile_row['Barangay'];
                        $_SESSION['City'] = $profile_row['City'];
                        $_SESSION['Province'] = $profile_row['Province'];
                        $_SESSION['Region'] = $profile_row['Region'];
                        $_SESSION['Postal_Code'] = $profile_row['Postal_Code'];
                        $_SESSION['Occupation'] = $profile_row['Occupation'];
                        $_SESSION['Education'] = $profile_row['Education'];
                        $_SESSION['Skills'] = $profile_row['Skills'];
                        $_SESSION['Notes'] = $profile_row['Notes'];
                        $_SESSION['profile_picture'] = $profile_row['profile_picture'];

                        header("Location: ../index.php");
                        exit();
                    } else {
                        header("Location: ../login-v2.php?error=Profile not found");
                        exit();
                    }
                } else {
                    // Account is not verified, redirect user to verification page
                    $_SESSION['verify'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['Email'];
                    header("Location: ../createdsuccessfully.php?error=Your account is not yet verified, please check your registered email and provide the valid verification code.");
                    exit();
                }
            } else {
                //if the password is not  correct then show error message and load the login form again
                header("Location: ../login-v2.php?error=Incorrect Email or Password");
                exit();
            }
        } else {
            //if the user is not existing in the database
            header("Location: ../login-v2.php?error=User not found");
            exit();
        }
    }
} else {
    header("Location: ../login-v2.php");
    exit();
}
?>
