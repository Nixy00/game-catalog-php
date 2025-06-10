<?php

declare(strict_types=1);

namespace Entity;

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
}