<?php
    session_start();

    //Turns hardmode on then instantly leaves
    $_SESSION['hardModeTrue'] = TRUE;
    header("Location: game.php");
?>