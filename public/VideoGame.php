<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use Entity\Collection\GameCollection;
use Entity\Game;
use html\AppWebPage;

$webPage = new AppWebPage();

$gameId = (int) $_GET['id'];

$game = Game::findByGameId($gameId);

$title = $game->getName();

$webPage->setTitle('Jeu Vidéo - ' . $title);

echo $webPage->toHTML();