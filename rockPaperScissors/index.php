<?php
require_once "model/RockPaperScissors.php";
require_once "view/view_lib.php";

session_save_path("sess");
session_start();

$errors = [];
$view = "";

if (!isset($_SESSION["RockPaperScissors"])) {
    $_SESSION["RockPaperScissors"] = new RockPaperScissors();
}

$instanceGame = $_SESSION["RockPaperScissors"];

if (!isset($_SESSION["state"])) {
    $_SESSION["state"] = "login";
}

switch ($_SESSION["state"]) {
    case "login":
        $view = "login.php";
        if (!empty($_REQUEST["submit"]) && $_REQUEST["submit"] == "login") {
            if (empty($_REQUEST["user"])) {
                $errors[] = "User is required";
            }
            if (empty($_REQUEST["password"])) {
                $errors[] = "Password is required";
            }
            if (empty($errors)) {
                if (
                    $_REQUEST["user"] == "csc309" &&
                    $_REQUEST["password"] == "password"
                ) {
                    $_SESSION["state"] = "play";
                    $view = "play.php";
                } else {
                    $errors[] = "Invalid login";
                }
            }
        }
        break;

    case "play":
        $view = "play.php";
        if (!empty($_REQUEST["choice"])) {
            if (in_array($_REQUEST["choice"], ["rock", "paper", "scissors"])) {
                $instanceGame->startGame($_REQUEST["choice"]);

                $score = $instanceGame->getScore();
                if ($score["user"] == 5 || $score["opponent"] == 5) {
                    $_SESSION["state"] = "won";
                    $view = "won.php";
                }
            } else {
                $errors[] = "Invalid pick";
            }
        }
        break;

    case "won":
        $view = "won.php";
        if (!empty($_REQUEST["submit"])) {
            if ($_REQUEST["submit"] == "yes") {
                $_SESSION["RockPaperScissors"] = new RockPaperScissors();
                $_SESSION["state"] = "play";
                $view = "play.php";
            } elseif ($_REQUEST["submit"] == "no") {
                $_SESSION = [];
                session_destroy();
                $view = "login.php";
            }
        }
        break;
}

require_once "view/$view";
?>
