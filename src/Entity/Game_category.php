<?php

declare(strict_types=1);

namespace Entity;

class Game_category
{
    private int $gameId;
    private int $categoryId;

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

}