<?php
session_start();

include "db_conn.php";

if (isset($_POST['upload'])) {
    // Getting user ID and username from session
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Combining user ID, username, and a random number to create a unique file identifier
    $file = $user_id . '-' . $username;

    // Getting the name, extension, temporary location, and size of the uploaded file
    $file_name = $_FILES['file']['name'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];

    // Specifying the folder where the uploaded file will be stored
    $folder = "../profile-picture/";

    // Allowed file extensions
    $allowed_extensions = array('png', 'jpg', 'jpeg');

    // Checking if the uploaded file has an allowed extension
    if (!in_array(strtolower($file_ext), $allowed_extensions)) {
        // Redirecting with an error message if the file type is not supported
        header("Location: ../profile.php?proferror=Upload failed, file type is not supported. Please upload PNG, JPG, or JPEG file type only.");
        exit();
    }

    $final_file = strtolower($file) . '.' . $file_ext;

    // Preparing the SQL statement to update the database with the new profile picture file name
    $sql = "UPDATE user_profile SET profile_picture=? WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);

    // Binding parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "si", $final_file, $user_id);
    mysqli_stmt_execute($stmt);

    // Checking if the file was moved successfully to the specified folder
    if (move_uploaded_file($file_loc, $folder . $final_file)) {
        // Updating the session variable with the new profile picture file name
        $_SESSION['profile_picture'] = $final_file;

        // Redirecting with a success message after successful upload
        header("Location: ../profile.php?profsuccess=Your new profile Picture has been updated successfully.");
        exit();
    } else {
        // Redirecting with an error message if the upload fails
        header("Location: ../profile.php?proferror=Upload failed.");
        exit();
    }
} else {
    header("Location: ../profile.php");
    exit();
}
?>
