<?php
    session_start();

    //if someone is cheeky and enters this url, redirect to index (could use robots.txt but i have no idea how)
    if(!isset($_SESSION['word'])){
        header("Location: index.php");
    }
    else{
        //Turn hints on then leave instantly
        $_SESSION['hintTrue'] = TRUE;
        $_SESSION['cheat'] ++;
        header("Location: game.php");
    }
?>
