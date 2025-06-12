<?php

declare(strict_types=1);

namespace Entity;

class Game_genre
{
    private int $gameId;
    private int $genreId;

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function getGenreId(): int
    {
        return $this->genreId;
    }

    public function getGenre(): Genre
    {
        return Genre::findById($this->getGenreId());
    }

}