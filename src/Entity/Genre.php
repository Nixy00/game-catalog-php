<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $description;

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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Cette fonction cherche un genre dans la base de données par son ID
     * @param int $id
     * @return Genre
     */
    public static function findById(int $id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, description
            FROM genre 
            WHERE id = :id
        SQL
        );
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Genre::class);
        $data = $stmt->fetch();
        if (!$data) {
            throw new EntityNotFoundException("Aucun genre avec l’ID $id");
        }
        return $data;
    }
}