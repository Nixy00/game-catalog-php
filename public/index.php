<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use html\WebPage;

$webPage = new WebPage('Jeux Vidéo');

$webPage->appendContent("<h1>Jeux Vidéo</h1>");

$webPage->appendContent("<h1>Genres</h1>");

$videoGames = GenreCollection::findAll();

foreach($videoGames as $game) {
    $name = $game->getDescription();
    $id = $game->getId();
    $ligneCorrect = $webPage->escapeString($name);
    $webPage->appendContent("<p><a href='Jeux.php?Id={$id}'>{$name}</a></p>");
}

$webPage->appendContent("<h1>Catégories</h1>");

$videoGames = CategoryCollection::findAll();

foreach($videoGames as $game){
    $name = $game->getDescription();
    $id = $game->getId();
    $ligneCorrect = $webPage->escapeString($name);
    $webPage->appendContent("<p><a href='Jeux.php?Id={$id}'>{$name}</a></p>");
}

$webPage->appendContent("<p>Dernière modification : {$webPage->getLastModification()}</p>");

echo $webPage->toHTML();