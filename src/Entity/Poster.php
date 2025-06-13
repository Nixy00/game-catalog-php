<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Poster
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $jpeg;

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
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * Cette fonction cherche un poster dans la base de données par son ID
     * @param int $id
     * @return Poster
     */
    public static function findById(int $id): Poster
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT poster.id, jpeg
            FROM poster
            JOIN game ON game.posterId = poster.id
            WHERE poster.id = :id
        SQL
        );
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Poster::class);
        $poster = $stmt->fetch();
        if (!$poster) {
            throw new EntityNotFoundException("Aucun poster avec l’ID $id");
        }
        return $poster;
    }
}