<?php
session_start();
//defines the highscore
if (!isset($_SESSION['wins'])) {
   $_SESSION['wins'] = 0;
}
if (!isset($_SESSION['mute'])) {
   $_SESSION['mute'] = FALSE;
}

if (!isset($_SESSION['wins'])) {
   $_SESSION['wins'] = 0;
}

if (!isset($_SESSION['hardReset'])) {
   $_SESSION['hardReset'] = FALSE;
}

if ($_SESSION['hardReset'] == TRUE) {
   $_SESSION['wins'] = 0;
   $_SESSION['hardReset'] = FALSE;
}
//delete all sessions except for the wins and mute settings
$requiredSessionVar = array('mute', 'wins');
foreach ($_SESSION as $key => $value) {
   if (!in_array($key, $requiredSessionVar)) {
      unset($_SESSION[$key]);
   }
}
$_SESSION['hardModeTrue'] = FALSE; //Turns off hardmode 
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

<body class="bg-blue cursor">
   <div>
      <h1 class="title">Bear Built!</h1>
   </div>
   <div class="display-link round bg-yellow">
      <div class="left">
         <img class="left" src="images/bear6.jpeg" width="150" height="150">
      </div>
      <div class="allign-right">
         <button type="button" class="button turn-text left" onclick="location.href = 'mute.php'">Mute</button><br>
         <button type="button" class="button turn-text left" onclick="location.href = 'hardReset.php'">Reset Score</button>
      </div>
      <h2 class="text-centre">Wins: <?php sleep(1); echo $_SESSION['wins']; ?></h2><br>
      <h2 class="text-centre">Choose a Game Mode:</h2>
      <!--Difficulty options, all redirect to unique pages redirect-->
      <button class="title-link" onclick="location.href = 'game.php'">Easy</button>
      <br><br><button class="title-link" onclick="location.href = 'hard.php'">Hard</button>
      <br><br><button class="title-link" onclick="location.href = 'impossible.php'">IMPOSSIBLE</button>
      <br><br><button class="title-link" onclick="location.href = 'oneGuess.php'">One guess challenge</button>
      <br><br><button class="title-link" onclick="location.href = 'blindMode.php'">Blind</button>
      <div class="right">
         <img src="images/bear6.jpeg" width="150" height="150">
      </div>
   </div>

   <audio autoplay loop id="music">
      <source src="sounds/music/Komiku_-_10_-_Fetch_Fever.mp3" type="audio/mpeg">
   </audio>
   <script>
      document.body.style.zoom = 0.66;
      var audio = document.getElementById("music");
      audio.volume = 0.5;
      var music = document.getElementById("music");

      <?php if ($_SESSION['mute'] == FALSE) {
      ?>music.play();
      <?php
      } else {
      ?>music.pause();
      <?php
      }
      ?>
   </script>
</body>

</html>