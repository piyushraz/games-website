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
				require_once "lib/lib.php";
				session_save_path("sess");
				session_start(); 

				$dbconn = db_connect();

				$errors=array();
				$view="";

				/* controller code */
				if(!isset($_SESSION['state'])){
					$_SESSION['state']='login';
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
							$_SESSION['state']='play';
							$view="play.php";
						} else {
							$errors[]="invalid login";
						}
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
							$errors[]="Invalid request";
							$view="won.php";
						}

						// validate and set errors
						if(!empty($errors))break;


						// perform operation, switching state and view if necessary
						$_SESSION["GuessGame"]=new GuessGame();
						$_SESSION['state']="play";
						$view="play.php";

						break;
				}
				require_once "view/$view";
			?>
			</section>
		</main>
	</body>
</html>

