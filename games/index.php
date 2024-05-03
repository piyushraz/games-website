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
    </header>
    <main>
        <section>
            <?php
				require_once "model/GuessGame.php";
				require_once "model/RockPaperScissors.php";
				require_once "model/FrogPuzzle.php";
				require_once "lib/lib.php";
				session_save_path("sess");
				session_start(); 
				$dbconn = db_connect();
				$errors=array();
				$view="";
				if (isset($_GET['state'])) {
					if ($_GET['state'] == 'register') {
						$_SESSION['state'] = 'register';
						$view = "register.php";
					} elseif ($_GET['state'] == 'login') {
						$_SESSION['state'] = 'login';
						$view = "login.php";
					}
				}
				if (!isset($_SESSION["RockPaperScissors"])) {
					$_SESSION["RockPaperScissors"] = new RockPaperScissors();
				}
				$instanceGame = $_SESSION["RockPaperScissors"];
				$score = $instanceGame->getScore();
				if (!isset($_SESSION['GuessGame'])) {
					$_SESSION['GuessGame'] = new GuessGame();
				}
				if(!isset($_SESSION['state'])){
					$_SESSION['state']='login';
				}
				if(isset($_GET['logout']) && $_GET['logout'] == 'true'){
					$_SESSION = array();
					session_destroy();
					header("Location: index.php");
					exit();
				}
				if(isset($_GET['allstats']) && $_GET['allstats'] == 'true'){
					$_SESSION['state']='all_stats';
					$view="all_stats.php";
					unset($_GET['allstats']);
				}
				if(isset($_GET['profile']) && $_GET['profile'] == 'true'){
					$_SESSION['state']='profile';
					$view="profile.php";
					unset($_GET['profile']);
				}
				if (isset($_GET['playrps']) && $_GET['playrps'] == 'true' && ($score["user"] == 5 || $score["opponent"] == 5)) {
					$_SESSION["state"] = "wonrps";
					$view = "wonrps.php";
					unset($_GET['playrps']);
				}
				if(isset($_GET['playrps']) && $_GET['playrps'] == 'true'){
					$instanceGame = $_SESSION["RockPaperScissors"];
					$_SESSION['state']='playrps';
					$view="playrps.php";
					unset($_GET['playrps']);
				}
				if(isset($_GET['guess_game']) && $_GET['guess_game'] == 'true' && $_SESSION["GuessGame"]->getState()=="correct"){
					$_SESSION['state']="won";
					$view="won.php";
					unset($_GET['guess_game']);
				}
				if(isset($_GET['guess_game']) && $_GET['guess_game'] == 'true'){
					$_SESSION['state']='play';
					$view="play.php";
					unset($_GET['guess_game']);
				}
				if (isset($_POST['resetFrogGame']) && $_POST['resetFrogGame'] == 'froggame') {
					$_SESSION["FrogPuzzle"] = new FrogPuzzle(); 
					$_SESSION['state'] = 'playfrog'; 
					$view = "playfrog.php"; 
					unset($_POST['resetFrogGame']);
				}
				if(isset($_GET['playfrog']) && $_GET['playfrog'] == 'true'){
					$_SESSION['state']='playfrog';
					$view="playfrog.php";
					unset($_GET['playfrog']);
				}
				switch($_SESSION['state']){
					case 'register':
						$view = "register.php"; 
						if (!empty($_REQUEST['submit']) && $_REQUEST['submit'] == 'register') {
							$userregister = $_POST['userregister'] ?? '';
							$passwordregister = $_POST['passwordregister'] ?? '';
							$cpasswordregister = $_POST['cpasswordregister'] ?? '';
							$favorite_color = $_POST['favorite_color'] ?? '';
							$favorite_number = $_POST['favorite_number'] ?? '';
							$favorite_game = $_POST['favorite_game'] ?? '';
							if (empty($userregister)) {
								$errors[] = 'User is required.';
							}
							if (empty($passwordregister)) {
								$errors[] = 'Password is required.';
							} elseif ($passwordregister !== $cpasswordregister) {
								$errors[] = 'Passwords do not match.';
							}
							if ($favorite_number !== '' && !is_numeric($favorite_number)) {
								$errors[] = 'Favorite number must be a number.';
							}
							if (empty($errors)) {
								$result = pg_prepare($dbconn, "register_user", 
								'INSERT INTO appuser (
									userid, 
									password, 
									favorite_color, 
									favorite_number, 
									favorite_game,
									guessgame_wins, 
									guessgame_num_guesses, 
									guessgame_times_played, 
									guessgame_avg_guesses_per_game,
									rockpaperscissors_wins, 
									rockpaperscissors_losses, 
									rockpaperscissors_win_percentage,
									froggame_wins, 
									froggame_losses, 
									froggame_win_percentage
								) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15)'
								);
								$result = pg_execute($dbconn, "register_user", array(
									$userregister, 
									$passwordregister, 
									$favorite_color, 
									$favorite_number, 
									$favorite_game,
									0,  
									0,  
									0,  
									0,  
									0,  
									0, 
									0,  
									0,  
									0,  
									0	
								));
								if ($result) {
									$_SESSION['state'] = 'login';
									$view = "login.php"; 
								} else {
									$errors[] = "Username already taken";
								}
							}
						}
						if (!empty($errors)) {
							$_SESSION['errors'] = $errors;
							$view = "register.php"; 
						}
						break;
					case "login":
						$view="login.php";
						if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
							break;
						}
						if(empty($_REQUEST['user'])){
							$errors[]='user is required';
						}
						if(empty($_REQUEST['password'])){
							$errors[]='password is required';
						}
						if(!empty($errors))break;
						$query = "SELECT * FROM appuser WHERE userid=$1 and password=$2;";
								$result = pg_prepare($dbconn, "", $query);

								$result = pg_execute($dbconn, "", array($_REQUEST['user'], $_REQUEST['password']));
								if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
							$_SESSION['user']=$_REQUEST['user'];
							$_SESSION['GuessGame']=new GuessGame();
							$instanceGame = $_SESSION["RockPaperScissors"];
							$_SESSION['state']='all_stats';
							$view="all_stats.php";
						} else {
							$errors[]="invalid login";
						}
						break;
					case "all_stats":
						$view = "all_stats.php";
						break;
					case "profile":
						$view = "profile.php";
						break;
					case "play":
						$username = $_SESSION['user'];
						$view="play.php";
						if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"){
							break;
						}
						if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
						if(!empty($errors))break;
						$fetchStatsQuery = "SELECT guessgame_num_guesses, guessgame_times_played, guessgame_wins FROM appuser WHERE userid = $1";
						$fetchStatsResult = pg_prepare($dbconn, "fetch_user_stats", $fetchStatsQuery);
						$fetchStatsResult = pg_execute($dbconn, "fetch_user_stats", array($username));
						if ($row = pg_fetch_assoc($fetchStatsResult)) {
							$numGuesses = $row['guessgame_num_guesses'] + 1;
							$timesPlayed = $row['guessgame_times_played'];
							$wins = $row['guessgame_wins']; 
							$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
							if ($_SESSION["GuessGame"]->getState() == "correct") {
								$wins += 1;
								$timesPlayed += 1;
								$_SESSION['state'] = "won";
								$view = "won.php";
							}
							$_REQUEST['guess'] = ""; 
							$avgGuessesPerGame = $timesPlayed > 0 ? $numGuesses / $timesPlayed : 0;
							$updateStatsQuery = "UPDATE appuser SET guessgame_num_guesses = $1, guessgame_times_played = $2, guessgame_wins = $3, guessgame_avg_guesses_per_game = $4 WHERE userid = $5";
							$updateStatsResult = pg_prepare($dbconn, "update_user_stats", $updateStatsQuery);
							$updateStatsResult = pg_execute($dbconn, "update_user_stats", array($numGuesses, $timesPlayed, $wins, $avgGuessesPerGame, $username));
							if (!$updateStatsResult) {
								$errors[] = "Error updating";
							}
						} else {
							$errors[] = "Error getting stats.";
						}
						break;
					case "won":
						$view="play.php";
						if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="resetFrogGame"){
							$view="won.php";
						}
						if(!empty($errors))break;
						$_SESSION["GuessGame"]=new GuessGame();
						$_SESSION['state']="play";
						$view="play.php";
						break;
					case "playrps":
						$username = $_SESSION['user'];
						$view = "playrps.php";
						if (!isset($_SESSION["RockPaperScissors"])) {
							$_SESSION["RockPaperScissors"] = new RockPaperScissors();
						}
						if (!empty($_REQUEST["choice"])) {
							if (in_array($_REQUEST["choice"], ["rock", "paper", "scissors"])) {
								$instanceGame->startGame($_REQUEST["choice"]);
								$score = $instanceGame->getScore();
								if ($score["user"] == 5 || $score["opponent"] == 5) {
									$fetchStatsQuery = "SELECT rockpaperscissors_wins, rockpaperscissors_losses FROM appuser WHERE userid = $1";
									$fetchStatsResult = pg_prepare($dbconn, "fetch_rps_stats", $fetchStatsQuery);
									$fetchStatsResult = pg_execute($dbconn, "fetch_rps_stats", array($username));
									$row = pg_fetch_assoc($fetchStatsResult);
									if ($score["user"] == 5) {
										$wins = $row['rockpaperscissors_wins'] + 1;
										$losses = $row['rockpaperscissors_losses'];
									} else {
										$wins = $row['rockpaperscissors_wins'];
										$losses = $row['rockpaperscissors_losses'] + 1;
									}
									$totalGames = $wins + $losses;
									$winPercentage = ($totalGames > 0) ? ($wins / $totalGames) * 100 : 0;
									$updateStatsQuery = "UPDATE appuser SET rockpaperscissors_wins = $1, rockpaperscissors_losses = $2, rockpaperscissors_win_percentage = $3 WHERE userid = $4";
									$updateStatsResult = pg_prepare($dbconn, "update_rps_stats", $updateStatsQuery);
									$updateStatsResult = pg_execute($dbconn, "update_rps_stats", array($wins, $losses, $winPercentage, $username));
									if ($updateStatsResult) {
										$_SESSION["state"] = "wonrps";
										$view = "wonrps.php";
									} else {
										$errors[] = "Error updating Rock Paper Scissors stats";
									}
								}
							} else {
								$errors[] = "Invalid pick";
							}
						}
						break;
					case "wonrps":
						$view = "wonrps.php";
						if (!empty($_REQUEST["submit"])) {
							if ($_REQUEST["submit"] == "yes") {
								$_SESSION["RockPaperScissors"] = new RockPaperScissors();
								$_SESSION["state"] = "playrps";
								$view = "playrps.php";
							} elseif ($_REQUEST["submit"] == "logout") {
								$_SESSION = array();
								session_destroy();
								header("Location: index.php");
								exit();
							}
						}
						break;
					case "playfrog":
						$username = $_SESSION['user'];

						if (!isset($_SESSION["FrogPuzzle"])) {
							$_SESSION["FrogPuzzle"] = new FrogPuzzle();
						}
						if (isset($_POST['move'])) {
							$fromIndex = $_POST['move'];
							$toIndex = $_SESSION["FrogPuzzle"]->findNextMove($fromIndex);
							if ($toIndex !== null && !$_SESSION["FrogPuzzle"]->move($fromIndex, $toIndex)) {
								$errors[] = "Invalid move. Please try again.";
							}
						}
						$board = $_SESSION["FrogPuzzle"]->getBoard();
						if ($_SESSION["FrogPuzzle"]->checkWin() || $_SESSION["FrogPuzzle"]->checkForNoMoves()) {
						$query = "SELECT froggame_wins, froggame_losses FROM appuser WHERE userid = $1";
						$result = pg_prepare($dbconn, "fetch_frog_stats", $query);
						$result = pg_execute($dbconn, "fetch_frog_stats", array($username));
						$row = pg_fetch_assoc($result);
						}
						if ($_SESSION["FrogPuzzle"]->checkWin()) {
							$_SESSION['state'] = "wonfrog";
							$view = "wonfrog.php";
							$row['froggame_wins'] += 1;
							$winPercentage = (($row['froggame_wins'] + $row['froggame_losses']) > 0) ? round(($row['froggame_wins'] / ($row['froggame_wins'] + $row['froggame_losses'])) * 100, 2) : 0;
							$updateQuery = "UPDATE appuser SET froggame_wins = $1, froggame_losses = $2, froggame_win_percentage = $3 WHERE userid = $4";
							$updateResult = pg_prepare($dbconn, "update_frog_stats", $updateQuery);
							$updateResult = pg_execute($dbconn, "update_frog_stats", array($row['froggame_wins'], $row['froggame_losses'], $winPercentage, $username));
						} elseif ($_SESSION["FrogPuzzle"]->checkForNoMoves()) {
							$row['froggame_losses'] += 1;
							$errors[] = "No moves left! Game over.";
							$view = "wonfrog.php";
							$winPercentage = (($row['froggame_wins'] + $row['froggame_losses']) > 0) ? round(($row['froggame_wins']  / ($row['froggame_wins']  + $row['froggame_losses'])) * 100, 2) : 0;
							$updateQuery = "UPDATE appuser SET froggame_wins = $1, froggame_losses = $2, froggame_win_percentage = $3 WHERE userid = $4";
							$updateResult = pg_prepare($dbconn, "update_frog_stats", $updateQuery);
							$updateResult = pg_execute($dbconn, "update_frog_stats", array($row['froggame_wins'] , $row['froggame_losses'], $winPercentage, $username));
						} else {
							$view = "playfrog.php";
						}
						break;
					case "wonfrog":
						if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "froggame") {
							$_SESSION['state'] = 'wonfrog';
							$view = "wonfrog.php";
						} else {
							$_SESSION['state'] = 'wonfrog';
							$view = "wonfrog.php";
						}
						break;
				}
				require_once "view/$view";
			?>
        </section>
    </main>
</body>

</html>