<?php
$username = $_SESSION['user'] ?? ''; 
$query_stats = "SELECT guessgame_num_guesses, guessgame_times_played, guessgame_wins, guessgame_avg_guesses_per_game, rockpaperscissors_wins, 
rockpaperscissors_losses, rockpaperscissors_win_percentage, froggame_wins, froggame_losses, froggame_win_percentage FROM appuser WHERE userid = $1";
$dbexecute = pg_prepare($dbconn, "fetch_extended_game_stats", $query_stats);
$dbexecute = pg_execute($dbconn, "fetch_extended_game_stats", array($username));

if ($row = pg_fetch_assoc($dbexecute)) {
    $guessGameNumGuesses = $row['guessgame_num_guesses'];
    $guessGameTimesPlayed = $row['guessgame_times_played'];
    $guessGameWins = $row['guessgame_wins'];
    $guessGameAvgGuessesPerGame = $row['guessgame_avg_guesses_per_game'];
    $rockPaperScissorsWins = $row['rockpaperscissors_wins'];
    $rockPaperScissorsLosses = $row['rockpaperscissors_losses'];
    $rockPaperScissorsWinPercentage = $row['rockpaperscissors_win_percentage'];
    $frogGameWins = $row['froggame_wins'];
    $frogGameLosses = $row['froggame_losses'];
    $frogGameWinPercentage = $row['froggame_win_percentage'];
} else {
    $guessGameNumGuesses = $guessGameTimesPlayed = $guessGameWins = $guessGameAvgGuessesPerGame = 'N/A';
    $rockPaperScissorsWins = $rockPaperScissorsLosses = $rockPaperScissorsWinPercentage = 'N/A';
    $frogGameWins = $frogGameLosses = $frogGameWinPercentage = 'N/A';
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
        <?php include "nav.php"; ?>
    </header>
    <main>
        <section>
            <h1>Stats by Game</h1>
            <p>Guess Game Statistics:</p>
            <ul>
                <li>Number of Guesses: <?php echo htmlspecialchars($guessGameNumGuesses); ?></li>
                <li>Times Played: <?php echo htmlspecialchars($guessGameTimesPlayed); ?></li>
                <li>Wins: <?php echo htmlspecialchars($guessGameWins); ?></li>
                <li>Average Guesses per Game: <?php echo htmlspecialchars($guessGameAvgGuessesPerGame); ?></li>
            </ul>
            <p>Rock Paper Scissors Statistics:</p>
            <ul>
                <li>Wins: <?php echo htmlspecialchars($rockPaperScissorsWins); ?></li>
                <li>Losses: <?php echo htmlspecialchars($rockPaperScissorsLosses); ?></li>
                <li>Win Percentage: <?php echo htmlspecialchars($rockPaperScissorsWinPercentage); ?>%</li>
            </ul>
            <p>Frog Game Statistics:</p>
            <ul>
                <li>Wins: <?php echo htmlspecialchars($frogGameWins); ?></li>
                <li>Losses: <?php echo htmlspecialchars($frogGameLosses); ?></li>
                <li>Win Percentage: <?php echo htmlspecialchars($frogGameWinPercentage); ?>%</li>
            </ul>
        </section>
    </main>
    <footer>
        A project by Piyush
    </footer>
</body>

</html>