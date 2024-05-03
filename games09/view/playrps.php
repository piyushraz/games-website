<?php

if (!isset($_SESSION["RockPaperScissors"])) {
    $_SESSION["RockPaperScissors"] = new RockPaperScissors();
}

$game = $_SESSION["RockPaperScissors"];
?>

<?php
$username = $_SESSION['user']; 

$query = "SELECT rockpaperscissors_wins, rockpaperscissors_losses, rockpaperscissors_win_percentage FROM appuser WHERE userid = $1";
$result = pg_prepare($dbconn, "", $query);
$result = pg_execute($dbconn, "", array($username));

$rockpaperscissorsWins = "UNKNOWN";
$rockpaperscissorsLosses = "UNKNOWN";
$rockpaperscissorsWinPercentage = "UNKNOWN";

if ($row = pg_fetch_assoc($result)) {
    $rockpaperscissorsWins= $row['rockpaperscissors_wins'];
    $rockpaperscissorsLosses = $row['rockpaperscissors_losses'];
    $rockpaperscissorsWinPercentage= $row['rockpaperscissors_win_percentage'];
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
            <h1>Play Rock Paper Scissors</h1>

            <?php foreach ($game->getHistory() as $round): ?>
            <p><?php echo htmlspecialchars($round); ?></p>
            <?php endforeach; ?>

            <h4>You won: <?php echo $game->getScore()[
				"user"
			]; ?> I won: <?php echo $game->getScore()["opponent"]; ?></h4>

            <form method="post">
                <input type="submit" name="choice" value="rock">
                <input type="submit" name="choice" value="paper">
                <input type="submit" name="choice" value="scissors">
            </form>
        </section>
        <section>
            <h1>RockPaperScissors - Game Stats</h1>
            <p>Wins: <?php echo htmlspecialchars($rockpaperscissorsWins); ?></p>
            <p>Losses: <?php echo htmlspecialchars($rockpaperscissorsLosses); ?></p>
            <p>Win Percentage: <?php echo htmlspecialchars($rockpaperscissorsWinPercentage); ?>%</p>
        </section>
    </main>
    <footer>
        A project by Piyush
    </footer>
</body>

</html>