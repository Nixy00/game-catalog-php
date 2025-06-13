<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

/**
 *
 */
class Game
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var int
     */
    protected int $releaseYear;
    /**
     * @var string
     */
    private string $shortDescription;
    /**
     * @var int
     */
    protected int $price;
    /**
     * @var int
     */
    protected int $windows;
    /**
     * @var int
     */
    protected int $linux;
    /**
     * @var int
     */
    protected int $mac;
    /**
     * @var int|null
     */
    protected ?int $metacritic;
    /**
     * @var int|null
     */
    protected ?int $developerId;
    /**
     * @var int
     */
    protected int $posterId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getWindows(): int
    {
        return $this->windows;
    }

    /**
     * @return int
     */
    public function getLinux(): int
    {
        return $this->linux;
    }

    /**
     * @return int
     */
    public function getMac(): int
    {
        return $this->mac;
    }

    /**
     * @return int|null
     */
    public function getMetacritic(): int|null
    {
        return $this->metacritic;
    }

    /**
     * @return int|null
     */
    public function getDeveloperId(): int|null
    {
        return $this->developerId;
    }

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * Cette fonction cherche un jeu dans la base de données par son ID
     * @param int $id
     * @return Game
     */
    public static function findById(int $id): Game
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, name, releaseYear, shortDescription, price, windows, linux, mac, metacritic, posterId, developerId
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

    /**
     * Cette fonction retourne toutes les catégories d'un jeu
     * @return array
     */
    public function getAllCategory(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, description
            FROM category
            JOIN game_category ON category.id = game_category.categoryId
            WHERE game_category.gameId = :id
        SQL
        );

        $stmt->execute(['id' => $this->getId()]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Category::class);
        $category = $stmt->fetchAll();

        if (!$category) {
            throw new EntityNotFoundException("Le jeu avec la catégorie avec l’ID : " . $this->getId() . "est introuvable");
        }

        return $category;
    }

    /**
     * Cette fonction retourne touts les genres d'un jeu
     * @return array
     */
    public function getAllGenres(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, description 
            FROM genre
            JOIN game_genre ON genre.id = game_genre.genreId
            WHERE game_genre.gameId = :id
        SQL
        );

        $stmt->execute(['id' => $this->getId()]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        $genre = $stmt->fetchAll();

        if (!$genre) {
            throw new EntityNotFoundException("Le jeu avec l'ID : " . $this->getId() . "est introuvable");
        }
        return $genre;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $releaseYear
     * @return void
     */
    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    /**
     * @param string $shortDescription
     * @return void
     */
    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @param int $price
     * @return void
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @param int $windows
     * @return void
     */
    public function setWindows(int $windows): void
    {
        $this->windows = $windows;
    }

    /**
     * @param int $linux
     * @return void
     */
    public function setLinux(int $linux): void
    {
        $this->linux = $linux;
    }

    /**
     * @param int $mac
     * @return void
     */
    public function setMac(int $mac): void
    {
        $this->mac = $mac;
    }

    /**
     * @param int|null $metacritic
     * @return void
     */
    public function setMetacritic(?int $metacritic): void
    {
        $this->metacritic = $metacritic;
    }

    /**
     * @param int|null $developerId
     * @return void
     */
    public function setDeveloperId(?int $developerId): void
    {
        $this->developerId = $developerId;
    }

    /**
     * @param int $posterId
     * @return void
     */
    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }
}