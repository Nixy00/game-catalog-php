<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Game;
use PDO;

class GameCollection extends Game
{
    public static function findAll(): array
    {
        $game = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT *
        FROM game
        ORDER BY name
        SQL
        );
        $game->execute();
        return $game->fetchAll(PDO::FETCH_CLASS, Game::class);
    }
    /* méthode à faire pour avoir la liste des jeux en fonction de leurs id
    La fonction n'est peut-être pas au bon endroit mais j'ai pas le temps de le faire la bulle ferme
    les salles */
    public static function findById(int $artistId): array
    {
        $albums = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, year, artistId, genreId, coverId
            FROM album
            WHERE artistId = :artistId
            ORDER BY year DESC, name ASC
            SQL
        );
        $albums->execute([':artistId' => $artistId]);
        return $albums->fetchAll(PDO::FETCH_CLASS, Game::class);
    }
}