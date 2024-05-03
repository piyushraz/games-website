<?php
if (!isset($_SESSION["RockPaperScissors"])) {
    $_SESSION["RockPaperScissors"] = new RockPaperScissors();
}
$game = $_SESSION["RockPaperScissors"];
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
            <?php
            $game = $_SESSION["RockPaperScissors"];
            $userScore = $game->getScore()["user"];
            $randomScore = $game->getScore()["opponent"];
            echo "<h4>You won: {$userScore} I won: {$randomScore}</h4>";
            if ($userScore > $randomScore) {
                echo "<h1 style='font-size: 2em; font-weight: bold;'>You WON!!</h1>";
            } else {
                echo "<h1 style='font-size: 2em; font-weight: bold;'>I WON!!</h1>";
            }
            ?>
            <form action="index.php" method="post">
                <span>Play again?</span>
                <input type="submit" name="submit" value="yes" />
                <input type="submit" name="submit" value="logout" />
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