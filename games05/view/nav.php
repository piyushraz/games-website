<?php

$allStatsClass = '';
$guessGameClass = '';
$rockPaperScissorsClass = '';
$frogsClass = '';
$profileClass = '';
$logoutClass = '';


if (isset($_SESSION['state'])) {
    switch ($_SESSION['state']) {
        case 'play':
            $guessGameClass = 'set';
            break;
		case 'won':
			$guessGameClass = 'set';
			break;
    }
}
?>


<nav>
    <ul>
        <li class="all-stats <?= $allStatsClass; ?>"><a href="">All Stats</a></li>
        <li class="guess-game <?= $guessGameClass; ?>"><a href="">Guess Game</a></li>
        <li class="rock-paper-scissors <?= $rockPaperScissorsClass; ?>"><a href="">Rock Paper Scissors</a></li>
        <li class="frogs <?= $frogsClass; ?>"><a href="">Frogs</a></li>
        <li class="profile <?= $profileClass; ?>"><a href="">Profile</a></li>
        <li class="logout <?= $logoutClass; ?>"><a href="index.php?logout=true">Logout</a></li>
    </ul>
</nav>