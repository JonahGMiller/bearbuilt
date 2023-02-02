<?php
    //resets win score then redirects
    session_start();
    $_SESSION['hardReset'] = TRUE;
    header("Location: index.php");
?>