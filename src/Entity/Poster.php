<?php

declare(strict_types=1);

namespace Entity;

class poster
{
    private int $id;
    private string $jpeg;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->jpeg;
    }
}