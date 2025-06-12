<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Game
{
    private int $id;
    private string $name;
    protected int $releaseYear;
    private string $shortDescription;
    protected int $price;
    protected int $windows;
    protected int $linux;
    protected int $mac;
    protected int $metacritic;
    protected int $developerId;
    protected int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getWindows(): int
    {
        return $this->windows;
    }

    public function getLinux(): int
    {
        return $this->linux;
    }

    public function getMac(): int
    {
        return $this->mac;
    }

    public function getMetacritic(): int
    {
        return $this->metacritic;
    }

    public function getDeveloperId(): int
    {
        return $this->developerId;
    }

    public function getPosterId(): int
    {
        return $this->posterId;
    }
    public static function findById(int $id): Game
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
        $game = $stmt->fetch();
        if (!$game) {
            throw new EntityNotFoundException("Aucun jeu avec l’ID $id");
        }
        return $game;
    }

    public function getAllCategory(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM category
            JOIN game_category ON category.id = game_category.categoryId
            WHERE game_category.gameId = :id
        SQL
        );

        $stmt->execute(['id' => $this->getId()]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Game::class);
        $category = $stmt->fetchAll();

        if (!$category) {
            throw new EntityNotFoundException("Le jeu avec la catégorie avec l’ID : " . $this->getId() . "est introuvable");
        }

        return $category;
    }

    public function getAllGenres(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT
            FROM genre
            JOIN game_genre ON genre.id = game_genre.genreId
            WHERE game_genre.gameId = :id
        SQL
        );

        $stmt->execute(['id' => $this->getId()]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Game::class);
        $genre = $stmt->fetchAll();

        if (!$genre) {
            throw new EntityNotFoundException("Le jeu avec l'ID : " . $this->getId() . "est introuvable");
        }
        return $genre;
    }
}