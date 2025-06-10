<?php

declare(strict_types=1);

namespace Entity;

class Game
{
    private int $id;
    private string $name;
    protected int $releaseYear;
    private string $shortDescription;
    protected int $price;
    protected int $windows;
    protected int $linux;
    protected int $mac;
    protected int $metacritic;
    protected int $developerId;
    protected int $posterId;

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