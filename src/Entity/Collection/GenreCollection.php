<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenreCollection
{
    public static function findAll(): array
    {
        $genre = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT *
        FROM genre
        ORDER BY description
        SQL
        );
        $genre->execute();
        return $genre->fetchAll(PDO::FETCH_CLASS, Genre::class);
    }
}