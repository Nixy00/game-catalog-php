<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Category
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
     * Cette fonction cherche une catégorie dans la base de données par son ID
     * @param int $id
     * @return Category
     */
    public static function findById(int $id): Category
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM category
            WHERE id = :id
        SQL
        );
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $category = $stmt->fetch();
        if (!$category) {
            throw new EntityNotFoundException("Aucune catégorie avec l’ID $id");
        }
        return $category;
    }
}