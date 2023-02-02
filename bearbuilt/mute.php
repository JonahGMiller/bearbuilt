<?php
    session_start();
    if($_SESSION['mute'] == FALSE){
        $_SESSION['mute'] = TRUE;
    }
    elseif($_SESSION['mute'] == TRUE){
        $_SESSION['mute'] = FALSE;
    }
    if(isset($_SESSION['word'])){
        header("Location: game.php");
    }
    else{
        header("Location: index.php");
    }
?>