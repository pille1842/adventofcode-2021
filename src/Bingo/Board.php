<?php

namespace PilleAoc2021\Bingo;

class Board
{
    protected array $content;
    protected array $marks;
    protected int $rows;
    protected int $cols;

    public function __construct(array $content)
    {
        $this->content = $content;
        $this->rows = count($content);
        $this->cols = count($content[0]);
        $this->marks = [];

        for ($y = 0; $y < $this->rows; $y++) {
            $this->marks[$y] = [];

            for ($x = 0; $x < $this->cols; $x++) {
                $this->marks[$y][$x] = false;
            }
        }
    }

    public function mark(int $number): void
    {
        for ($y = 0; $y < $this->rows; $y++) {
            for ($x = 0; $x < $this->cols; $x++) {
                if ($this->content[$y][$x] == $number) {
                    $this->marks[$y][$x] = true;
                }
            }
        }
    }

    public function wins(): bool
    {
        for ($y = 0; $y < $this->rows; $y++) {
            $allInRowMarked = true;

            for ($x = 0; $x < $this->cols; $x++) {
                if (!$this->marks[$y][$x]) {
                    $allInRowMarked = false;
                }
            }

            if ($allInRowMarked) {
                return true;
            }
        }

        for ($x = 0; $x < $this->cols; $x++) {
            $allInColumnMarked = true;

            for ($y = 0; $y < $this->rows; $y++) {
                if (!$this->marks[$y][$x]) {
                    $allInColumnMarked = false;
                }
            }

            if ($allInColumnMarked) {
                return true;
            }
        }

        return false;
    }

    public function sumUnmarkedNumbers(): int
    {
        $sum = 0;

        for ($y = 0; $y < $this->rows; $y++) {
            for ($x = 0; $x < $this->cols; $x++) {
                if (!$this->marks[$y][$x]) {
                    $sum += $this->content[$y][$x];
                }
            }
        }

        return $sum;
    }
}
