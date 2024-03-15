<?php
session_start();

include "db_conn.php";

if (
    isset($_POST['currentPassword']) && isset($_POST['newPassword'])
    && isset($_POST['retypeNewPassword'])
) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $currentPassword = validate($_POST['currentPassword']);
    $newPassword = validate($_POST['newPassword']);
    $retypeNewPassword = validate($_POST['retypeNewPassword']);


    // Fetch username from session
    $uname = $_SESSION['username'];

    // Check if new passwords and retyping new password is match
    if ($newPassword !== $retypeNewPassword) {
        header("Location: ../profile.php?passerror=Passwords do not match.");
        exit();
    }

    // Check if current password is correct
    $sql = "SELECT password FROM user WHERE username='$uname'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) { // Checking the username if existing
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];
        if (!password_verify($currentPassword, $storedPassword)) { //this will promptif current password is not match in the password stored in the table
            header("Location: ../profile.php?passerror=Incorrect current password.");
            exit();
        }
    } else { //this will promptif the user is not found in the table
        header("Location: ../profile.php?passerror=User not found.");
        exit();
    }

    // Hash the new password
    $hashed_new_password = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_sql = "UPDATE user SET password='$hashed_new_password' WHERE username='$uname'";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {
        $_SESSION['password'] = $stored_password;
        header("Location: ../profile.php?passsuccess=Password updated successfully."); // this will prompt if it was successfully changed the password
        exit();
    } else {
        header("Location: ../profile.php?error=Failed to update password.");// this will prompt if it was failed changed the password
        exit();
    }
} else {
    header("Location: ../profile.php");
    exit();
}
