<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Game;
use PDO;

class GameCollection
{
    /**
     * Cette fonction permet de chercher un jeu par sa catégorie
     * @param int $categoryId
     * @return array
     */
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

    /**
     * Cette fonction permet de chercher un jeu par son genre
     * @param int $genreId
     * @return array
     */
    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, posterId
            FROM game
            JOIN game_genre ON game.id = game_genre.gameId
            WHERE game_genre.genreId = :id
            ORDER BY releaseYear, name
        SQL
        );

        $stmt->execute(['id' => $genreId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Game::class);
    }

    /**
     * Cette fonction cherche un jeu dans la base de données par son ID
     * @param int $id
     * @return array
     */
    public static function findById(int $id): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, posterId
            FROM game
            WHERE id = :id
        SQL
        );

        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Game::class);

        return $stmt->fetchAll();
    }
}