<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use Entity\Collection\GameCollection;
use Entity\Game;
use Entity\Developer;
use html\AppWebPage;

$webPage = new AppWebPage();

$gameId = (int) $_GET['id'];

$game = Game::findById($gameId);

$title = $game->getName();

$webPage->setTitle('Jeu Vidéo - ' . $title);

$price = $game->getPrice() / 100;

$webPage->appendContent("<p>{$game->getReleaseYear()}</p>");
$webPage->appendContent("<p>{$game->getMetacritic()}</p>");
$webPage->appendContent("<p>{$price}€</p>");
$webPage->appendContent("<p>{$game->getShortDescription()}</p>");

/*
if($game->getMac() === 1){
    $webPage->appendContent("<img src='img/apple.svg'>");
}
if($game->getLinux() === 1){
    $webPage->appendContent("<img src='img/linux.svg'>");
}
if($game->getWindows() === 1){
    $webPage->appendContent("<img src='img/windows.svg'>");
}
*/

$developerId = $game->getDeveloperId();
$developer = Developer::findById($developerId);

$webPage->appendContent("<p>{$developer->getName()}</p>");



echo $webPage->toHTML();