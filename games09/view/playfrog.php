<?php
$username = $_SESSION['user']; 
$query = "SELECT froggame_wins, froggame_losses, froggame_win_percentage FROM appuser WHERE userid = $1";
$result = pg_prepare($dbconn, "", $query);
$result = pg_execute($dbconn, "", array($username));
$frogGameWins = "UNKNOWN";
$frogGameLosses = "UNKNOWN";
$frogGameWinPercentage = "UNKNOWN";
if ($row = pg_fetch_assoc($result)) {
    $frogGameWins = $row['froggame_wins'];
    $frogGameLosses = $row['froggame_losses'];
    $frogGameWinPercentage = $row['froggame_win_percentage'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Frog Puzzle Game</title>
</head>

<body>
    <header>
        <?php include "nav.php"; ?>
    </header>
    <main>
        <section>
            <h1>Frog Puzzle Game</h1>
            <form method="post" action="index.php">
                <?php 
                if (isset($board)) {
                    echo '<table class="frog-table"><tr class="frog-row">';
                    foreach ($board as $index => $cell) {
                        $image = 'empty.gif'; 
                        if ($cell == "yellow") $image = 'yellowFrog.gif';
                        if ($cell == "green") $image = 'greenFrog.gif';
                        echo "<td class='frog-cell'>";
                        echo "<button type='submit' name='move' value='{$index}'>";
                        echo "<img src='{$image}' alt='Frog' />";
                        echo "</button>";
                        echo "</td>";
                    }
                    echo '</tr></table>';
                } else {
                    echo "<p>Error: Board data is not available.</p>";
                }
                if ($_SESSION["FrogPuzzle"]->checkForNoMoves()) {
                    echo "<p>No moves left! Game over.</p>";
                    echo "<button type='submit' name='resetFrogGame' value='froggame'>Play Again</button>";
                }
            ?>
            </form>
        </section>
        <section>
            <h1>Frog Puzzle - Game Stats</h1>
            <p>Wins: <?php echo htmlspecialchars($frogGameWins); ?></p>
            <p>Losses: <?php echo htmlspecialchars($frogGameLosses); ?></p>
            <p>Win Percentage: <?php echo htmlspecialchars($frogGameWinPercentage); ?>%</p>
        </section>
    </main>
    <footer>
        A project by Piyush
    </footer>
</body>

</html>