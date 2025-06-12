<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Game;
use PDO;

class GameCollection
{
    public static function findByCategoryId(int $categoryId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM game
            JOIN game_category ON game.id = game_category.gameId
            WHERE game_category.categoryId = :id
            ORDER BY releaseYear, name
        SQL
        );

        $stmt->execute(['id' => $categoryId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Game::class);

        return $stmt->fetchAll();
    }

    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM game
            JOIN game_genre ON game.id = game_genre.gameId
            WHERE game_genre.genreId = :id
            ORDER BY releaseYear, name
        SQL
        );

        $stmt->execute(['id' => $genreId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Game::class);

        return $stmt->fetchAll();
    }

    public static function findById(int $id): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM game
            WHERE id = :id
        SQL
        );

        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Game::class);

        return $stmt->fetchAll();
    }
}