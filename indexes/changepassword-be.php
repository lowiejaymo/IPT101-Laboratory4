<?php
session_start();

include "db_conn.php";

// Check if all required fields are set
if (
    isset($_POST['currentPassword']) && isset($_POST['newPassword'])
    && isset($_POST['retypeNewPassword'])
) {
    // Function to sanitize user input
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Sanitize input data
    $currentPassword = validate($_POST['currentPassword']);
    $newPassword = validate($_POST['newPassword']);
    $retypeNewPassword = validate($_POST['retypeNewPassword']);

    // Fetch username from session
    $uname = $_SESSION['username'];

    // Check if new passwords and retyped new password match
    if ($newPassword !== $retypeNewPassword) {
        header("Location: ../profile.php?passerror=Passwords do not match.");
        exit();
    }

    // Check if current password is correct
    $sql = "SELECT password FROM user WHERE username=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $uname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // If username exists in the database
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];
        // Verify if current password matches stored password
        if (!password_verify($currentPassword, $storedPassword)) {
            header("Location: ../profile.php?passerror=Incorrect current password.");
            exit();
        }
    } else {
        // Username not found in the database
        header("Location: ../profile.php?passerror=User not found.");
        exit();
    }

    // Hash the new password
    $hashed_new_password = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_sql = "UPDATE user SET password=? WHERE username=?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ss", $hashed_new_password, $uname);
    $update_result = mysqli_stmt_execute($update_stmt);

    if ($update_result) {
        // Update password in session
        $_SESSION['password'] = $hashed_new_password;
        // Redirect with success message
        header("Location: ../profile.php?passsuccess=Password updated successfully.");
        exit();
    } else {
        // Redirect with error message if update fails
        header("Location: ../profile.php?error=Failed to update password.");
        exit();
    }
} else {
    // Redirect if required fields are not set
    header("Location: ../profile.php");
    exit();
}
