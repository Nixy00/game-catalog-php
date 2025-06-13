<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Developer
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
    public static function findById(int $id): Developer | null
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM developer
            WHERE id = :id
        SQL
        );
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Developer::class);
        $dev = $stmt->fetch();
        if (!$dev) {
            throw new EntityNotFoundException("Aucun développeur avec l’ID $id");
        }
        return $dev;
    }
}