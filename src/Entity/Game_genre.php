<?php

declare(strict_types=1);

namespace Entity;

class Game_genre
{
    /**
     * @var int
     */
    private int $gameId;
    /**
     * @var int
     */
    private int $genreId;

    /**
     * @return int
     */
    public function getGameId(): int
    {
        return $this->gameId;
    }

    /**
     * Cette fonction nous permet d'avoir l'ID du genre d'un jeu
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /**
     * Cette fonction nous permet d'avoir tout les jeu du même genre
     * @return Genre
     */
    public function getGenre(): Genre
    {
        return Genre::findById($this->getGenreId());
    }

}