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
				ini_set('display_errors', 'On');
				require_once "model/GuessGame.php";
				require_once "model/RockPaperScissors.php";
				require_once "lib/lib.php";
				session_save_path("sess");
				session_start(); 

				$dbconn = db_connect();

				$errors=array();
				$view="";

				if (!isset($_SESSION["RockPaperScissors"])) {
					$_SESSION["RockPaperScissors"] = new RockPaperScissors();
				}
				$instanceGame = $_SESSION["RockPaperScissors"];
				$score = $instanceGame->getScore();


				
				if (!isset($_SESSION['GuessGame'])) {
					$_SESSION['GuessGame'] = new GuessGame();
				}

				/* controller code */
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
				
				if(isset($_GET['unavail']) && $_GET['unavail'] == 'true'){
					$_SESSION['state']='unavailable';
					$view="unavailable.php";
					unset($_GET['unavail']);
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

				switch($_SESSION['state']){
					case "login":
						// the view we display by default
						$view="login.php";

						// check if submit or not
						if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
							break;
						}

						// validate and set errors
						if(empty($_REQUEST['user'])){
							$errors[]='user is required';
						}
						if(empty($_REQUEST['password'])){
							$errors[]='password is required';
						}
						if(!empty($errors))break;

						// perform operation, switching state and view if necessary
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

					case "unavailable":
						$view = "unavailable.php";
						break;


					case "play":
						// the view we display by default
						$view="play.php";

						// check if submit or not
						if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"){
							break;
						}

						// validate and set errors
						if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
						if(!empty($errors))break;

						// perform operation, switching state and view if necessary
						$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
						if($_SESSION["GuessGame"]->getState()=="correct"){
							$_SESSION['state']="won";
							$view="won.php";
						}
						$_REQUEST['guess']="";

						break;

					case "won":
						// the view we display by default
						$view="play.php";

						// check if submit or not
						if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="play again"){
							$view="won.php";
						}

						// validate and set errors
						if(!empty($errors))break;


						// perform operation, switching state and view if necessary
						$_SESSION["GuessGame"]=new GuessGame();
						$_SESSION['state']="play";
						$view="play.php";
						break;

					case "playrps":
						$view = "playrps.php";

						if (!isset($_SESSION["RockPaperScissors"])) {
							$_SESSION["RockPaperScissors"] = new RockPaperScissors();
						}
					

						if (!empty($_REQUEST["choice"])) {
							if (in_array($_REQUEST["choice"], ["rock", "paper", "scissors"])) {
								$instanceGame->startGame($_REQUEST["choice"]);
				
								$score = $instanceGame->getScore();
								if ($score["user"] == 5 || $score["opponent"] == 5) {
									$_SESSION["state"] = "wonrps";
									$view = "wonrps.php";
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

				}
				require_once "view/$view";
			?>
			</section>
		</main>
	</body>
</html>

