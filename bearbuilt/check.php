<?php
    //starts session, not required for this page but may as well
    session_start();

    //if someone is cheeky and enters this url, redirect to index (could use robots.txt but i have no idea how)
    if(!isset($_SESSION['word'])){
        header("Location: index.php");
    }

    //Stores the word that has been chosen and turns it into an array splitting the letters
    $wordToGuess = str_split($_SESSION['word']);

    //Stores the letter that has been guessed
    $letterGuessed = $_POST['letterGuess'];

    //Check if the letter is in the chosen word
    if (in_array($letterGuessed, $wordToGuess)){
        //Inserts the guessed letter into array
        array_push($_SESSION['correctGuesses'], $letterGuessed);
        //Add to number of correct guesses
        $_SESSION['correctAttempts'] ++;
    }
    else {
        //if wrong then increase the amount of wrong trys and add letter to different array
        array_push($_SESSION['incorrectGuesses'], $letterGuessed);
        //Add to number of incorrect guesses
        $_SESSION['attempts'] ++;
    } 

    //debugging goodies
    // print($letterGuessed);
    // echo "<br>";
    // print_r($_SESSION['incorrectGuesses']);
    // print_r($_SESSION['correctGuesses']);

    //cheeky little redirect
    header("Location: game.php");
?>
