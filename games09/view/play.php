<?php
	$_REQUEST['guess']=!empty($_REQUEST['guess']) ? $_REQUEST['guess'] : '';
?>
<?php
$username = $_SESSION['user']; 
$query = "SELECT guessgame_wins, guessgame_num_guesses, guessgame_times_played, guessgame_avg_guesses_per_game FROM appuser WHERE userid = $1";
$result = pg_prepare($dbconn, "", $query);
$result = pg_execute($dbconn, "", array($username));
$guessgameWins = "UNKNOWN";
$guessgameNumGuesses = "UNKNOWN";
$guessgame_times_played = "UNKNOWN";
$guessgame_Avg_Guesses_Per_Game = "UNKNOWN";
if ($row = pg_fetch_assoc($result)) {
	$guessgameWins = $row['guessgame_wins'];
	$guessgameNumGuesses = $row['guessgame_num_guesses'];
	$guessgame_times_played = $row['guessgame_times_played'];
	$guessgame_Avg_Guesses_Per_Game = $row['guessgame_avg_guesses_per_game'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Games</title>
</head>

<body>
    <header>
        <?php 
				include "nav.php";
			?>
    </header>
    <main>
        <section>
            <h1>Guess Game</h1>
            <?php if($_SESSION["GuessGame"]->getState()!="correct"){ ?>
            <form method="post">
                <input type="text" name="guess" value="<?php echo($_REQUEST['guess']); ?>" /> <input type="submit"
                    name="submit" value="guess" />
            </form>
            <?php } ?>
            <?php echo(view_errors($errors)); ?>
            <?php 
					foreach($_SESSION['GuessGame']->history as $key=>$value){
						echo("<br/> $value");
					}
					if($_SESSION["GuessGame"]->getState()=="correct"){ 
				?>
            <form method="post">
                <input type="submit" name="submit" value="play again" />
            </form>
            <?php 
					} 
				?>
        </section>
        <section>
            <h1>GuessGame - Game Stats</h1>
            <p>All Time Guesses: <?php echo htmlspecialchars($guessgameNumGuesses); ?></p>
            <p>Times Played: <?php echo htmlspecialchars($guessgame_times_played); ?></p>
            <p>Wins: <?php echo htmlspecialchars($guessgameWins); ?></p>
            <p>Average Guesses per Game: <?php echo htmlspecialchars($guessgame_Avg_Guesses_Per_Game); ?></p>
        </section>
    </main>
    <footer>
        A project by Piyush
    </footer>
</body>

</html>