<?php
    session_start();
    //Turn hints on then leave instantly
    $_SESSION['blindMode'] = TRUE;
    header("Location: game.php");
?>