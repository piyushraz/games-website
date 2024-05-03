<?php

if (!isset($_SESSION['user'])) {
    $_SESSION['state'] = 'login';
    $view = "login.php";
    include "view/$view";
    exit();
}
$username = $_SESSION['user']; 
$messages = [];
$query = "SELECT password, favorite_color, favorite_number, favorite_game FROM appuser WHERE userid = $1";
$info_result = pg_prepare($dbconn, "fetch_user_info", $query);
$info_result = pg_execute($dbconn, "fetch_user_info", array($username));
$user_info = pg_fetch_assoc($info_result);
if (isset($_POST['update_password'])) {
    $new_password = $_POST['new_password'] ?? '';
    $current_password = $user_info['password'] ?? '';
    if ($new_password === $current_password) {
        $messages[] = "Set a new password instead.";
    } else {
        $query = "UPDATE appuser SET password = $1 WHERE userid = $2";
        $result = pg_prepare($dbconn, "update_password", $query);
        $result = pg_execute($dbconn, "update_password", array($new_password, $username));
        if ($result) {
            $messages[] = "Password updated successfully.";
        } else {
            $messages[] = "Password update failed";
        }
    }
}
$favorite_color = !empty($user_info['favorite_color']) ? $user_info['favorite_color'] : null;
$favorite_number = !empty($user_info['favorite_number']) ? $user_info['favorite_number'] : null;
$favorite_game = !empty($user_info['favorite_game']) ? $user_info['favorite_game'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>User Profile - Games</title>
</head>

<body class="profile-page">
    <header>
        <?php include "nav.php"; ?>
    </header>
    <main>
        <section>
            <h1>User Profile</h1>
            <p class="welcome-message">Welcome, <?php echo htmlspecialchars($username); ?></p>
            <?php if ($favorite_color): ?>
            <p>Your favorite color is: <?php echo htmlspecialchars($favorite_color); ?></p>
            <?php endif; ?>
            <?php if ($favorite_number): ?>
            <p>Your favorite number is: <?php echo htmlspecialchars($favorite_number); ?></p>
            <?php endif; ?>
            <?php if ($favorite_game): ?>
            <p>Your favorite game is: <?php echo htmlspecialchars($favorite_game); ?></p>
            <?php endif; ?>
            <form action="index.php?state=profile" method="post">
                <label for="new_password">Set New Password (max length 50 characters):</label>
                <input type="password" id="new_password" name="new_password" maxlength="50" required>
                <input type="submit" name="update_password" value="Update Password">
            </form>
            <?php foreach ($messages as $message): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>
        A project by Piyush
    </footer>
</body>

</html>