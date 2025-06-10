<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Game;
use PDO;

class GameCollection
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
}