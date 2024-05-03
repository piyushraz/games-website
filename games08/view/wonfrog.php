<?php
	$_REQUEST['guess']=!empty($_REQUEST['guess']) ? $_REQUEST['guess'] : '';
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
            <h1>Frog Puzzle Game - Game Over</h1>
            <?php
                if (isset($_SESSION["FrogPuzzle"]) && $_SESSION["FrogPuzzle"] instanceof FrogPuzzle) {
                    if ($_SESSION["FrogPuzzle"]->checkWin()) {
                        echo "<p>Congratulations! You've won the game!</p>";
                    } else {
                        echo "<p>No more moves left! Game over.</p>";
                    }
                } else {
                    echo "<p>Error: Issue.</p>";
                }
            ?>
            <form action="index.php" method="post">
                <button type="submit" name="resetFrogGame" value="true">Play Again</button>
            </form>
        </section>
    </main>
    <footer>
        A project by ME
    </footer>
</body>

</html>