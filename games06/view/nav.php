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
        case 'all_stats':
            $allStatsClass = 'set';
			break;

        case 'rps':
            $rockPaperScissorsClass = 'set';
            break;

    }
}
?>


<nav>
    <ul>
        <li class="all-stats <?= $allStatsClass; ?>"><a href="index.php?allstats=true">All Stats</a></li>
        <li class="guess-game <?= $guessGameClass; ?>"><a href="index.php?guess_game=true">Guess Game</a></li>
        <li class="rock-paper-scissors <?= $rockPaperScissorsClass; ?>"><a href="index.php?rps=true">Rock Paper Scissors</a></li>
        <li class="frogs <?= $frogsClass; ?>"><a href="index.php?unavail=true">Frogs</a></li>
        <li class="profile <?= $profileClass; ?>"><a href="index.php?unavail=true">Profile</a></li>
        <li class="logout <?= $logoutClass; ?>"><a href="index.php?logout=true">Logout</a></li>
    </ul>
</nav>