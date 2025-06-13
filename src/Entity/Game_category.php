<?php

declare(strict_types=1);

namespace Entity;

class Game_category
{
    /**
     * @var int
     */
    private int $gameId;
    /**
     * @var int
     */
    private int $categoryId;

    /**
     * @return int
     */
    public function getGameId(): int
    {
        return $this->gameId;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

}