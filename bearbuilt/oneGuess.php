<?php
    session_start();

    //Turns one guess on then instantly leaves
    $_SESSION['oneGuess'] = TRUE;
    header("Location: game.php");
?>