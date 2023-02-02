<?php
   //Ensures that the sessions has started
    session_start();

   //word list
   //array of arrays with 2 values
   $wordList = array( // 'Word, Category, Hint'
       array("PNEUMONOULTRAMICROSCOPICSILICOVOLCANOCONIOSIS", "diseases", "A rare lung" ), 
       array("HIPPOPOTOMONSTROSESQUIPPEDALIOPHOBIA", "phobias", "Phobia of long words" ),
       array("PSEUDOPSEUDOHYPOPARATHYROIDISM ", "health conditions", "An inherited condition that causes short stature , round face, and short hand bones" ),
       array("FLOCCINAUCINIHILIPILIFICATION ", "verbs", "Estimating something as worthless" ),
       array("HONORIFICABILITUDINITATIBUS", "nouns", "The state of being able to achieve honours" ),
       array("THYROPARATHYROIDECTOMIZED", "surgical procedure", "Surgical removal of the thyroid and parathyroid glands." ),
       
   );
   
   //game start function
   //if there is no word then choose one and set all temp values to 0
   if(!isset($_SESSION['word'])){
      //Resets game state to be new
      $_SESSION['attempts'] = 0;
      $_SESSION['gameover'] = FALSE;
      $_SESSION['gamewon'] = FALSE;
      $_SESSION['isPlaying'] = TRUE;
      $_SESSION['hintTrue'] = FALSE;

      //Turns of hard difficulty
      $_SESSION['hardMode'] = TRUE;
      $_SESSION['maxTurns'] = 6;

      //Ensures that the hint is not active
      $_SESSION['hintTrue'] = FALSE;

      //suffles word lsit and picks top array
      $totalWordList = array_rand($wordList, count($wordList));
      shuffle($totalWordList);
      $randWordAndCategory = $wordList[$totalWordList[0]];
         
      //chooses the first and second value in the array
      $_SESSION['word'] = $randWordAndCategory[0];
      $_SESSION['category'] = $randWordAndCategory[1];
      $_SESSION['hint'] = $randWordAndCategory[2];

      //Stores correct and incorrect guesses
      $_SESSION['correctGuesses'] = array();
      $_SESSION['incorrectGuesses'] = array();

      $_SESSION['correctAttempts'] = 0;
   }
    //Redirect to game page
    header("Location: game.php");
?>