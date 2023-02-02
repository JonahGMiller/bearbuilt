<?php
   //Ensures that the sessions has started
    session_start();
   
   //word list
   //array of arrays with 2 values
   $wordList = array( // 'Word, Category, Hint'
       array("APPLE", "food", "Eat it once a day to keep the doctor away" ), //foods
       array("ORANGE", "food", "Both a colour and a fruit"),
       array("PIZZA", "food", "A circular classic"),
       array("PASTA", "food", "A great italian dish"),
       array("SPAGHETTI", "food", "A great Italian dish"),
       array("CHOCOLATE", "food", "A popular treat"),
       array("BURGER", "food", "A Western staple"),
       array("HOT DOG", "food", "A New York classic"),
       array("ICE CREAM", "food", "I scream, you scream"),
       array("PUMPKIN", "food", "A spooky snack"),
       array("RICE", "food", "An Asian staple"),
       array("LEMON", "food", "A great flavour with a sour punch"),
       array("COOKIE", "food", "A monsters faviourite snack"),
       array("BEAN", "food", "A long green veggie"),
   
       array("AUSTRALIA", "country", "Best known for it's beaches"), //countries
       array("FRANCE", "country", "Best known for it's arts and revolutions"),
       array("GERMANY", "country", "Best known for it's car manufacturing"),
       array("INDONESIA", "country", "Home to the komodo dragons"),
       array("UNITED STATES", "country", "Yee haw"),
       array("CANADA", "country", "Best known for it's syrp"),
       array("ITALY", "country", "Known for being the birthplace of the Roman empire"),
       array("CHINA", "country", "The world's factory"),
       array("JAPAN", "country", "The land of the rising sun"),
       array("EGYPT", "country", "Houses one of the sandy-est wonders of the world"),
       array("GREECE", "country", "Best known for its mythology"),
       array("MEXICO", "country", "A North American country known for it's unique cuisine"),
   
       array("BLUE", "colour", "The colour of the seas and skies"), //colours
       array("RED", "colour", "The colour of love and hate"),
       array("GREEN", "colour", "The colour of life"),
       array("ORANGE", "colour", "A mix between red and yellow"),
       array("PURPLE", "colour", "A mix between red and blue"),
       array("YELLOW", "colour", "The colour of the sun"),
       array("BROWN", "colour", "A mix of every colour"),
       array("CYAN", "colour", "The printer version of blue"),
       array("BLACK", "colour", "The colour of passing and darkness"),
       array("WHITE", "colour", "The colour of purity and righteousness"),
       array("GREY", "colour", "A mix between black and white"),
       array("VIOLET", "colour", "The final colour of the rainbow"),
   
       array("MONKEY", "animal", "The cheekiest out there"), //animals
       array("TURTLE", "animal", "A well protected swimmer"),
       array("RAT", "animal", "The lamb of the sewer"),
       array("FROG", "animal", "A high jumping pest"),
       array("CAT", "animal", "Man's second best friend"),
       array("RABBIT", "animal", "A hopping pest"),
       array("SNAKE", "animal", "A deciving reptile"),
       array("LION", "animal", "King of the jungle"),
       array("PANDA", "animal", "A bamboo eating bear"),
       array("CAMEL", "animal", "The horse of the desert"),
       array("CHICKEN", "animal", "A glorified bird"),
       array("TIGER", "animal", "A striped predator"),
       array("DRAGON", "animal", "A mythical beast"),
   
       array("TEDDY BEAR", "toy", "Great for snuggling"),
       array("LEGO", "toy", "A construction toy"),
       array("DOLL", "toy", "A toy of a person"),  
       array("RACE CAR", "toy", "A fast toy"), 
       array("PLAY DOUGH", "toy", "A dough like toy"),
       array("PAINT SET", "toy", "An artistic toy"), 
       array("FOOTBALL", "toy", "A great toy to throw or kick"),
       array("BLOCKS", "toy","Great for construction"),
       array("DICE", "toy","A toy that when rolled shows a number"),
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
      $_SESSION['hardMode'] = FALSE;
      $_SESSION['maxTurns'] = 12;

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

   //important key variables V V V 

   //converts session into local variable because they are annoying to type
   $totalAttempts = $_SESSION['attempts'];

   //Makes a string with a value for each letter
   $wordLetters = str_split($_SESSION['word']);
   
   //Splits all alphabet letters into a string
   $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $buttonLetters = str_split($alphabet);

   //counts all unique values within an array
   $unique = array_count_values($wordLetters);
   //excludes a space - could also be extend to unique symbols but not really needed
   unset($unique[' ']);





   //important game functions V V V 

   //difficulty and max attempts
   //If play has chosen to be on hard mode then it will do so
   if($_SESSION['hardModeTrue'] == TRUE){
      $_SESSION['hardMode'] = TRUE;
   }
   
   //Allows a max of 6 turns if on hard
   if($_SESSION['hardMode'] == TRUE){
      $_SESSION['maxTurns'] = 6;
   }

   if(!isset($_SESSION['wins'])){
      $_SESSION['wins'] = 0;
   }

   if(!isset($_SESSION['winsStop'])){
      $_SESSION['winsStop'] = FALSE;
   }

   //If the amount of correct guesses is equal to the amount of unique letters than win
   if($_SESSION['correctAttempts'] == count($unique)){
      $_SESSION['gamewon'] = TRUE;
   }

   //gameover
   //if attmpts reaches its max then its gameover
   if($_SESSION['attempts'] == $_SESSION['maxTurns']){
      $_SESSION['gameover'] = TRUE;
   }

   //If the game is over than stop playing
   if($_SESSION['gameover'] == TRUE){
      $_SESSION['isPlaying'] = FALSE;
   }

   //If the game has been won than stop playing
   if($_SESSION['gamewon'] == TRUE){
      if($_SESSION['winsStop'] == FALSE){
         $_SESSION['wins'] ++;
      }
      $_SESSION['isPlaying'] = FALSE;
   }

   if(!isset($_SESSION['debug'])){
      $_SESSION['debug'] = FALSE;
   }

   //If in hard mode then for each attempt change the number of turns left and the image
   if($_SESSION['hardMode'] == TRUE){
      if($totalAttempts == 0){
         $candleStage = "images/bear0.jpeg";
         $turnsLeft = 6;
      }
      if($totalAttempts == 1){
         $candleStage = "images/bear1.jpeg";
         $turnsLeft = 5;
      }
      if($totalAttempts == 2){
         $candleStage = "images/bear2.jpeg";
         $turnsLeft = 4;
      }
      if($totalAttempts == 3){
         $candleStage = "images/bear3.jpeg";
         $turnsLeft = 3;
      }
      if($totalAttempts == 4){
         $candleStage = "images/bear4.jpeg";
         $turnsLeft = 2;
      }
      if($totalAttempts == 5){
         $candleStage = "images/bear5.jpeg";
         $turnsLeft = 1;
      }
      if($totalAttempts == 6){
         $candleStage = "images/bear6.jpeg";
         $turnsLeft = 0;
      }
      if($totalAttempts >= 7){
         header("Location: index.php");
      }
   }
   
   elseif(isset($_SESSION['oneGuess'])){
      $candleStage = "images/bear5.jpeg";
      $turnsLeft = 1;
      $_SESSION['maxTurns'] = 1;
      if($totalAttempts == 1){
         $candleStage = "images/bear6.jpeg";
         $turnsLeft = 0;
      }
      if($totalAttempts >= 2){
         header("Location: index.php");
      }
   }
   //If not if hard mode or 1 guess then it must be in easy and do the same but with more turns
   else{
      if($totalAttempts == 0){
         $candleStage = "images/bear0.jpeg";
         $turnsLeft = 12;
      }
      if($totalAttempts == 1){
         $candleStage = "images/bear1.jpeg";
         $turnsLeft = 11;
      }
      if($totalAttempts == 2){
         $candleStage = "images/bear1.jpeg";
         $turnsLeft = 10;
      }
      if($totalAttempts == 3){
         $candleStage = "images/bear2.jpeg";
         $turnsLeft = 9;
      }
      if($totalAttempts == 4){
         $candleStage = "images/bear2.jpeg";
         $turnsLeft = 8;
      }
      if($totalAttempts == 5){
         $candleStage = "images/bear3.jpeg";
         $turnsLeft = 7;
      }
      if($totalAttempts == 6){
         $candleStage = "images/bear3.jpeg";
         $turnsLeft = 6;
      }
      if($totalAttempts == 7){
         $candleStage = "images/bear4.jpeg";
         $turnsLeft = 5;
      }
      if($totalAttempts == 8){
         $candleStage = "images/bear4.jpeg";
         $turnsLeft = 4;
      }
      if($totalAttempts == 9){
         $candleStage = "images/bear5.jpeg";
         $turnsLeft = 3;
      }
      if($totalAttempts == 10){
         $candleStage = "images/bear5.jpeg";
         $turnsLeft = 2;
      }
      if($totalAttempts == 11){
         $candleStage = "images/bear5.jpeg";
         $turnsLeft = 1;
      }
      if($totalAttempts == 12){
         $candleStage = "images/bear6.jpeg";
         $turnsLeft = 0;
      }
      if($totalAttempts >= 13){
         header("Location: index.php");
      }
   }


   if(!isset($_SESSION['debug'])){
      $_SESSION['debug'] = FALSE;
   }
   if(!isset($_SESSION['cheat'])){
      $_SESSION['cheat'] = 0;
  }

   //way to access debug
   if($_SESSION['cheat'] == 5){
      $_SESSION['debug'] = TRUE;
   }

   if($_SESSION['debug'] == TRUE){
      echo "<br>word: ";
      print $_SESSION['word'];
      echo "<br>category: ";
      print $_SESSION['category'];
      echo "<br>correct guesses: ";
      print_r($_SESSION['correctGuesses']);
      echo "<br>incorrect guesses: ";
      print_r($_SESSION['incorrectGuesses']);
      echo "<br>Attempts: ";
      print $_SESSION['attempts'];
      echo "<br>Max attempts: ";
      print $_SESSION['maxTurns'];
      echo "<br>Hint: ";
      print($_SESSION['hint']);
      echo "<br>Unique letters: ";
      print_r($unique);
      echo "<br>Correct attempts: ";
      print $_SESSION['correctAttempts'];
   }

   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="css/main.css">
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Bear Built!</title>
   </head>
   <body class="bg-blue cursor zoom">
      <div> 
         <h1 class="title">Bear Built!</h1>
      </div>
         <div class="display bg-yellow round centre">
            <div class="allign-left">
               <h3 class="turn-text">Turns left: <?php echo $turnsLeft?></h3>
               <!--Mute Button-->
               <button type="button" class="button turn-text left" onclick="location.href = 'mute.php'">Mute</button><br>
               <!--Back to index button-->
               <button type="button" class="button turn-text left" onclick="location.href = 'index.php'">Back</button>
            </div>
            <div>
               <!--image, candle refering to bear-->
               <img class="candleImage" src="<?php echo $candleStage;?>" alt="Candle stage ='<?php echo $turnsLeft;?>'" width="300" height="300"/> <br> 
            </div>
            <!--States the category-->
           <h1 class="title-category">The category is <?php echo $_SESSION['category'];?></h1>
            <!--letters-->
            <div>
               <?php
               if(isset($_SESSION['blindMode'])){
                  //if blind mode is on just do nothing
               }
               else{
                  //Loops through each letter of the word
                  foreach($wordLetters as $characters){
                     //Creates a space if there is a space in the word
                     if($characters == " "){
                        echo "&nbsp;&nbsp;&nbsp;";
                     } 
                     else {
                           //creates a text field for the letter which can't be changed
                           echo "<input class='letters cursor input' type='text' name='$characters' size='1' readonly value='"?><?php
                           //if there are characters that arent in the keyboard then automatically enter them
                           if(!in_array($characters, $buttonLetters)){
                                 echo $characters;
                           }
                           //If the letter was guessed, display it
                           if(in_array($characters, $_SESSION['correctGuesses'])){
                              echo $characters;
                           }
                           //if game is over show all letters
                           if($_SESSION['gameover'] == TRUE){
                              if(!in_array($characters, $_SESSION['correctGuesses'])){
                                 echo $characters;
                              }
                           }
                           echo "'>";
                     }
                  } 
               }
               ?>
            </div>
            <br>
               <div>
                  <!-- Keyboard -->
                  <form method="POST" action="check.php">
                  <?php 
                     if ($_SESSION['isPlaying'] == TRUE){
                        //Repeat button echo for each letter in the "buttonLetters" (the alphabet) array
                        foreach($buttonLetters as $letters){ 
                           echo " <button class='button' name='letterGuess' type='submit' value='$letters' "?>
                           <?php
                           //If letter was correct then disable it
                           if(in_array($letters, $_SESSION['correctGuesses'])){
                              echo 'disabled';
                           }
                           //If letter was incorrect then disable it
                           if(in_array($letters, $_SESSION['incorrectGuesses'])){
                              echo 'disabled';
                           }
                           ?>
                           <?php
                              echo " >" . $letters . "</button>";
                        }
                     }
                  ?>
                  </form>
                  <?php
                     //If the game has been won then display a win message w/ link
                     if($_SESSION['gamewon'] == TRUE){
                        //prevents player from refreshing page and getting a higher score
                        $_SESSION['winsStop'] = TRUE
                     ?><button class='title-link' onclick="location.href = 'index.php'">You win... Try again?</button><?php
                     } 
                     //If the game has been lost then display a lose message w/ link
                     if($_SESSION['gameover'] == TRUE){
                        ?><button class='title-link' onclick="location.assign('index.php')">You lose... Try again?</button><?php
                     }
                  ?>
               </div>
                     <!--Hint button redirects to another page, horribly inefficent but easier than using post or js-->
                     </form><br><button class='title-link text-black hover' onclick="location.href = 'hint.php'">Hint</button><br>
                     <?php
                     //If hint is true then display it
                     if($_SESSION['hintTrue'] == TRUE){
                        ?><h3 class='hint'><?php echo $_SESSION['hint'];
                     }
                  ?>
                  </h3>
                  </div>
      <!--Some pretty catchy tunes with cheeky js-->
      <!--Music is in the free domain, no credit needed :))-->
      <audio autoplay loop id="music">
         <source src="sounds/music/Komiku_-_10_-_Fetch_Fever.mp3" type="audio/mpeg">
      </audio>
      <script>
         function indexLink() {
            location.assign("index.php");
         }

         document.body.style.zoom = 0.75;
         var audio = document.getElementById("music");
         audio.volume = 0.5;
         var music = document.getElementById("music");

         <?php if($_SESSION['mute'] == FALSE){
            ?>music.play();<?php
         }
         else{
            ?>music.pause();<?php
         }
         ?>
      </script>
      
   </body>
</html>