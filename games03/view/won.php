<?php
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
			<nav>
				<ul>
				<li> <a href="">All Stats</a> </li>
				<li> <a href="">Guess Game</a> </li>
				<li> <a href="">Rock Paper Scissors</a> </li>
				<li> <a href="">Frogs</a> </li>
				<li> <a href="">Profile</a> </li>
				<li> <a href="">Logout</a> </li> 
                        	</ul>
			</nav>
		</header>
		<main>
			<section>
			<body>
				<h1>Guess Game</h1>
				<?php echo(view_errors($errors)); ?>
				<?php 
					foreach($_SESSION['GuessGame']->history as $key=>$value){
						echo("<br/> $value");
					}
				?>
				<form method="post">
					<input type="submit" name="submit" value="play again" />
				</form>
			</body>
			</section>
			<section class='stats'>
				<h1>Stats</h1>
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
				stats go here
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

