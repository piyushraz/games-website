<?php
$_REQUEST['userregister'] = $_REQUEST['userregister'] ?? '';
$_REQUEST['passwordregister'] = $_REQUEST['passwordregister'] ?? '';
$_REQUEST['cpasswordregister'] = $_REQUEST['cpasswordregister'] ?? '';
$_REQUEST['favorite_color'] = $_REQUEST['favorite_color'] ?? '';
$_REQUEST['favorite_number'] = $_REQUEST['favorite_number'] ?? '';
$_REQUEST['favorite_game'] = $_REQUEST['favorite_game'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Register - Games</title>
</head>

<body>
    <header>
        <nav>
            <ul>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h1>Register for Games</h1>
            <form action="index.php" method="post">
                <legend>Register</legend>
                <table>
                    <tr>
                        <th><label for="userregister">Username</label></th>
                        <td><input type="text" name="userregister"
                                value="<?php echo htmlspecialchars($_REQUEST['userregister']); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="passwordregister">Password</label></th>
                        <td><input type="password" name="passwordregister" /></td>
                    </tr>
                    <tr>
                        <th><label for="cpasswordregister">Confirm Password</label></th>
                        <td><input type="password" name="cpasswordregister" /></td>
                    </tr>
                    <tr>
                        <th><label for="favorite_color">Favorite Color</label></th>
                        <td><input type="text" name="favorite_color"
                                value="<?php echo htmlspecialchars($_REQUEST['favorite_color']); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="favorite_number">Favorite Number</label></th>
                        <td><input type="number" name="favorite_number"
                                value="<?php echo htmlspecialchars($_REQUEST['favorite_number']); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="favorite_game">Favorite Game</label></th>
                        <td>
                            <select name="favorite_game">
                                <option value="">Select a game</option>
                                <option value="FrogGame"
                                    <?php echo ($_REQUEST['favorite_game'] == 'FrogGame') ? 'selected' : ''; ?>>Frog
                                    Game</option>
                                <option value="GuessGame"
                                    <?php echo ($_REQUEST['favorite_game'] == 'GuessGame') ? 'selected' : ''; ?>>Guess
                                    Game</option>
                                <option value="RockPaperScissors"
                                    <?php echo ($_REQUEST['favorite_game'] == 'RockPaperScissors') ? 'selected' : ''; ?>>
                                    Rock Paper Scissors</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td><input type="submit" name="submit" value="register" /></td>
                    </tr>
                </table>
                <div>
                    <?php if(!empty($errors)): ?>
                    <ul>
                        <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </form>
            <a href="index.php?state=login">Back to login</a>
        </section>
        <section>
        </section>
    </main>
    <footer>
        A project by Piyush
    </footer>
</body>

</html>