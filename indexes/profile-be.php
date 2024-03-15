<?php
session_start();
include "db_conn.php";

if (isset($_POST['profile_password']) ) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $lastname = validate($_POST['lastname']);
    $firstname = validate($_POST['firstname']);
    $middlename = validate($_POST['middlename']);
    $uname = validate($_POST['uname']);
    $password = validate($_POST['profile_password']);
    

    $userid = $_SESSION['user_id']; // Get user ID from session or database
    $stored_password = $_SESSION['password']; // Make sure to replace with actual session variable

    // Verify the entered password
    if (empty($password)) {
		header("Location: ../profile.php?updateprofileerror=Password is required");
	    exit();
	}else if(empty($lastname)){
        header("Location: ../profile.php?updateprofileerror=Lastname is required");
	    exit();
	}else if(empty($firstname)){
        header("Location: ../profile.php?updateprofileerror=Firstname is required");
	    exit();
	}elseif (empty($uname)) {
		header("Location: ../profile.php?updateprofileerror=User Name is required");
	    exit();
	}elseif (!password_verify($_POST['profile_password'], $stored_password)) {
        header("Location: ../profile.php?updateprofileerror=Password is incorrect.");
        exit();
    }else{
        // Check if the new username is already taken (excluding current user's username)
    $current_username = $_SESSION['username'];
    $check_username_sql = "SELECT * FROM user WHERE username='$uname' AND username != '$current_username'";
    $check_username_result = mysqli_query($conn, $check_username_sql);

    if (mysqli_num_rows($check_username_result) > 0) {
        header("Location: ../profile.php?updateprofileerror=Username is already taken.");
        exit();
    }
    // Update the user's registration details
    $update_sql = "UPDATE user SET Lastname='$lastname', First_name='$firstname', Middle_name='$middlename', username='$uname' WHERE username='$current_username'";
    $update_result = mysqli_query($conn, $update_sql);

    // Prepare and execute the update query using prepared statements
    $stmt = $conn->prepare("UPDATE user_profile SET phone_number=?, Birthday=?, gender=?, street_building_house=?, 
    Barangay=?, City=?, Province=?, Region=?, Postal_code=?, Occupation=?, Education=?, Skills=?, Notes=? WHERE user_id=?");

    // Bind parameters
    $stmt->bind_param(
        "isssssssissssi",
        $_POST['phone_number'],
        $_POST['birthday'],
        $_POST['gender'],
        $_POST['street_building_house'],
        $_POST['barangay'],
        $_POST['city'],
        $_POST['province'],
        $_POST['region'],
        $_POST['postal_code'],
        $_POST['occupation'],
        $_POST['education'],
        $_POST['skills'],
        $_POST['notes'],
        $userid
    );

    // Execute the statement
    $update_resultotherinfo = $stmt->execute();

    if ($update_result && $update_resultotherinfo) {
        
        // Update the username in the session
        $_SESSION['Lastname'] = $lastname;
        $_SESSION['First_name'] = $firstname;
        $_SESSION['Middle_name'] = $middlename;
        $_SESSION['username'] = $uname;

        $_SESSION['phone_number'] = $_POST['phone_number'];
        $_SESSION['Birthday'] = $_POST['birthday'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['street_building_house'] = $_POST['street_building_house'];
        $_SESSION['Barangay'] = $_POST['barangay'];
        $_SESSION['City'] = $_POST['city'];
        $_SESSION['Province'] = $_POST['province'];
        $_SESSION['Region'] = $_POST['region'];
        $_SESSION['Postal_Code'] = $_POST['postal_code'];
        $_SESSION['Occupation'] = $_POST['occupation'];
        $_SESSION['Education'] = $_POST['education'];
        $_SESSION['Skills'] = $_POST['skills'];
        $_SESSION['Notes'] = $_POST['notes'];
        header("Location: ../profile.php?updateprofilesuccess=Your Personal Information has been successfully updated. ");
        exit();
    } else {
        header("Location: ../profile.php?updateprofileerror=Failed to update profile.");
        exit();
    }
    }

    
} else {
    // Redirect if the password is not set
    header("Location: ../profile.php?updateprofileerror=Password is required.");
    exit();
}
?>