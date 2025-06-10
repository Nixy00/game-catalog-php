<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Category;
use PDO;

class CategoryCollection
{
    public static function findAll(): array
    {
        $Category = MyPDO::getInstance()->prepare(
            <<<'SQL'
        SELECT *
        FROM category
        ORDER BY description
        SQL
        );
        $Category->execute();
        return $Category->fetchAll(PDO::FETCH_CLASS, Category::class);
    }
}