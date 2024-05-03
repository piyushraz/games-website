<?php
    class FrogPuzzle {
        public $board = ["yellow", "yellow", "yellow", "empty", "green", "green", "green"];

        public function move($from, $to) {
            if ($this->validMove($from, $to)) {
                $this->board[$to] = $this->board[$from];
                $this->board[$from] = "empty";
                return true;
            } else {
                return false;
            }
        }

        private function validMove($from, $to) {
            if ($to < 0 || $to >= count($this->board) || $this->board[$to] != "empty") {
                return false;
            }
            if ($this->board[$from] == "yellow" && ($to == $from + 1 || $to == $from + 2)) {
                return true;
            }
            if ($this->board[$from] == "green" && ($to == $from - 1 || $to == $from - 2)) {
                return true;
            }
            return false;
        }

        public function getBoard() {
            return $this->board;
        }

        public function checkWin() {
            return $this->board === ["green", "green", "green", "empty", "yellow", "yellow", "yellow"];
        }

        public function findNextMove($from) {
            if ($this->board[$from] == "yellow") {
                if ($from + 1 < count($this->board) && $this->board[$from + 1] == "empty") {
                    return $from + 1;
                } elseif ($from + 2 < count($this->board) && $this->board[$from + 2] == "empty") {
                    return $from + 2;
                }
            } elseif ($this->board[$from] == "green") {
                if ($from - 1 >= 0 && $this->board[$from - 1] == "empty") {
                    return $from - 1;
                } elseif ($from - 2 >= 0 && $this->board[$from - 2] == "empty") {
                    return $from - 2;
                }
            }
            return null;
        }

        public function checkForNoMoves() {
            for ($i = 0; $i < count($this->board); $i++) {
                if ($this->findNextMove($i) !== null) {
                    return false;
                }
            }
            return true;
        }

        public function resetBoard() {
            $this->board = ["yellow", "yellow", "yellow", "empty", "green", "green", "green"];
        }
    }
?>