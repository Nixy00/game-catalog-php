<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use html\AppWebPage;

$title = 'Jeux Vidéo';

$webPage = new AppWebPage($title);

$webPage->appendContent("<h1>Genres</h1>");

$videoGames = GenreCollection::findAll();

foreach($videoGames as $game) {
    $name = $game->getDescription();
    $id = $game->getId();
    $correctLine = $webPage->escapeString($name);
    $webPage->appendContent("<p><a href='Jeux.php?Id={$id}'>{$correctLine}</a></p>");
}

$webPage->appendContent("<h1>Catégories</h1>");

$videoGames = CategoryCollection::findAll();

foreach($videoGames as $game){
    $name = $game->getDescription();
    $id = $game->getId();
    $correctLine = $webPage->escapeString($name);
    $webPage->appendContent("<p><a href='Jeux.php?Id={$id}'>{$correctLine}</a></p>");
}

echo $webPage->toHTML();