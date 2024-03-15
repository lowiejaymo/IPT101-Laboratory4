<?php
session_start();

// this will unset and destroy the session, the user will not be able to open home.php or go back when user hit the logout button
session_unset();
session_destroy();

header("Location: ../login-v2.php");