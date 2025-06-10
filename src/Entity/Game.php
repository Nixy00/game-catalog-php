<?php

declare(strict_types=1);

namespace Entity;

class Game
{
    private int $id;
    private string $name;
    private int $releaseYear;
    private string $shortDescription;
    private int $price;
    private int $windows;
    private int $linux;
    private int $mac;
    private int $metacritic;
    private int $developerId;
    private int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getWindows(): int
    {
        return $this->windows;
    }

    public function getLinux(): int
    {
        return $this->linux;
    }

    public function getMac(): int
    {
        return $this->mac;
    }

    public function getMetacritic(): int
    {
        return $this->metacritic;
    }

    public function getDeveloperId(): int
    {
        return $this->developerId;
    }

    public function getPosterId(): int
    {
        return $this->posterId;
    }
}