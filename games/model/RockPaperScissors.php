<?php
    class RockPaperScissors {
        public $userScore = 0;
        public $randomScore = 0;
        public $history = [];
        public $state = "";
        public $round = 0;

        public function startGame($userSelect) {
            $choices = ["rock", "paper", "scissors"];
            $random_num = rand(0, 2);
            $randomUser = $choices[$random_num];
            if (
                ($userSelect == "rock" && $randomUser == "scissors") ||
                ($userSelect == "scissors" && $randomUser == "paper") ||
                ($userSelect == "paper" && $randomUser == "rock")
            ) {
                $this->userScore++;
                $this->state = "You won.";
            } elseif ($userSelect == $randomUser) {
                $this->state = "tie game.";
            } else {
                $this->randomScore++;
                $this->state = "I won.";
            }
            $this->round++;
            $this->history[] = "Round #{$this->round}, you chose $userSelect, I chose $randomUser, {$this->state}";
        }

        public function getScore() {
            return ["user" => $this->userScore, "opponent" => $this->randomScore];
        }

        public function getHistory() {
            return $this->history;
        }
    }
?>