<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Frog Game</title>
</head>

<body>
    <header>
        <?php include "nav.php"; ?>
    </header>
    <main>
        <section>
            <h1>Frog Game</h1>
            <form method="post" action="index.php">
                <?php 
                if (isset($board) && is_array($board)) {
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
                    echo "<p>Error.</p>";
                }
                if ($_SESSION["FrogPuzzle"]->checkForNoMoves()) {
                    echo "<p>No moves left! Game over.</p>";
                    echo "<button type='submit' name='resetFrogGame' value='true'>Play Again</button>";
                }
            ?>
            </form>
        </section>
    </main>
    <footer>
        A project by ME
    </footer>
</body>

</html>