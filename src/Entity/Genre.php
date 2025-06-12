<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $description;
    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function findById(int $id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id
            FROM genre 
            WHERE id = :genreId
        SQL
        );
        $stmt->execute([':genreId' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Genre::class);
        $data = $stmt->fetch();
        if (!$data) {
            throw new EntityNotFoundException("Aucun genre avec l’ID $id");
        }
        return $data;
    }
}