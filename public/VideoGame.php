<?php

declare(strict_types=1);

use Entity\Game;
use Entity\Developer;
use Entity\Genre;
use html\AppWebPage;

$webPage = new AppWebPage();

$gameId = (int) $_GET['gameId'];


$game = Game::findById($gameId);
$posterId = $game->getPosterId();
$title = $game->getName();

$webPage->setTitle('Jeu Vidéo - ' . $title);

$price = $game->getPrice() / 100;

$webPage->appendContent("<p>{$game->getReleaseYear()}</p>");
$webPage->appendContent("<p>{$game->getMetacritic()}</p>");
$webPage->appendContent("<p>{$price}€</p>");
$webPage->appendContent("<p>{$game->getShortDescription()}</p>");
$webPage->appendContent("<div> <img class='poster' src='poster.php?posterId={$posterId}' alt='Poster de la série {$webPage->escapeString($game->getName())}'/> </div>");

if($game->getMac() === 1){
    $webPage->appendContent("<img src='img/apple.svg' alt='logo apple'>");
}
if($game->getLinux() === 1){
    $webPage->appendContent("<img src='img/linux.svg' alt='logo linux'>");
}
if($game->getWindows() === 1){
    $webPage->appendContent("<img src='img/windows.svg' alt='logo windows'>");
}



$developerId = $game->getDeveloperId();
$developer = Developer::findById($developerId);

$webPage->appendContent("<p>{$developer->getName()}</p>");

$categories = $game->getAllCategory();

$webPage->appendContent("<h2>Catégories : </h2> <p> ");

foreach($categories as $category){
    $name = $category->getDescription();
    $webPage->appendContent("{$name}, ");
}

$webPage->appendContent("</p>");

$genres = $game->getAllGenres();

$webPage->appendContent("<h2>Genres : </h2> <p> ");

foreach($genres as $genre){
    $name = $genre->getDescription();
    $webPage->appendContent("{$name}, ");
}

$webPage->appendContent("</p>");

echo $webPage->toHTML();