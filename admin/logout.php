<?php
    session_start();
    session_destroy();
    session_start();
    $_SESSION['successMsg'] = "You have been successfully logged out!";
    header("Location: ../index.php");
?>