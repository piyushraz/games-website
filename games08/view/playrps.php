<?php
if (!isset($_SESSION["RockPaperScissors"])) {
    $_SESSION["RockPaperScissors"] = new RockPaperScissors();
}
$game = $_SESSION["RockPaperScissors"];
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
    </main>
    <footer>
        A project by ME
    </footer>
</body>

</html>