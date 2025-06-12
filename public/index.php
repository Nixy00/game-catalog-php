<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use html\AppWebPage;

$title = 'Jeux Vidéo';

$webPage = new AppWebPage($title);

$webPage->appendCssUrl('/css/style_page1.css');

$webPage->appendContent("<div class='row'><h2>Genres</h2>");

$videoGames = GenreCollection::findAll();

foreach($videoGames as $game) {
    $name = $game->getDescription();
    $id = $game->getId();
    $correctLine = $webPage->escapeString($name);
    $webPage->appendContent("<p><a class='bouton' href='genreJeux.php?Id={$id}'>{$correctLine}</a></p>");
}

$webPage->appendContent("</div><div class='row'><h2>Catégories</h2>");

$videoGames = CategoryCollection::findAll();

foreach($videoGames as $game){
    $name = $game->getDescription();
    $id = $game->getId();
    $correctLine = $webPage->escapeString($name);
    $webPage->appendContent("<p><a class='bouton' href='categorieJeux.php?Id={$id}'>{$correctLine}</a></p>");
}

$webPage->appendContent("</div>");

echo $webPage->toHTML();