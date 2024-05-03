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
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

