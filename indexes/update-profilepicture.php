<?php
session_start();

include "db_conn.php";

if (isset($_POST['upload'])) {

    $user_id = $_SESSION['user_id']; //getting the user_id
    $username = $_SESSION['username']; //getting username

    $file = $user_id . '-' . $username; //Combining user ID, username, and a random number to create a unique file identifier.
    $file_name = $_FILES['file']['name'];   // getting the name of the uploaded file
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); // Extracting the file extension from the file name
    $file_loc = $_FILES['file']['tmp_name']; // Getting the temporary location of the uploaded file.
    $file_size = $_FILES['file']['size']; // Retrieving the size of the uploaded file.
    $folder = "../profile-picture/"; // Specifying the folder where the uploaded file will be stored.

    // allowed file extensions
    $allowed_extensions = array('png', 'jpg', 'jpeg');

    if (!in_array(strtolower($file_ext), $allowed_extensions)) { // checking if the uploaded file has an allowed extension
        // redirecting with an error message if the file type is not supported
        header("Location: ../profile.php?proferror=Upload failed, file type is not supported. Please upload PNG, JPG, or JPEG file type only.");
exit();
    }
    
    $final_file = strtolower($file) . '.' . $file_ext;// creating the final file name with its extension

    // moving the uploaded file to the specified folder
    if(move_uploaded_file($file_loc, $folder.$final_file)){
        // updating the database with the new profile picture file name
        $sql = "UPDATE user_profile SET profile_picture=? WHERE user_id=?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "si", $final_file, $user_id);
        
        mysqli_stmt_execute($stmt);

        // updating the session variable with the new profile picture file name
        $_SESSION['profile_picture'] = $final_file;

        // redirecting with a success message after successful upload
        header("Location: ../profile.php?profsuccess=Your new profile Picture has been updated successfully.");
        exit();
    }else{
        // redirecting with an error message if the upload fails
        header("Location: ../profile.php?proferror=Upload failed.");
        exit();
    }
} else {
    header("Location: ../profile.php");
    exit();
}
?>
