<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GameCollection;
use Entity\Collection\GenreCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Genre;
use html\AppWebPage;

if (!isset($_GET['genreId']) || !is_numeric($_GET['genreId']) || (int)$_GET['genreId'] <= 0) {
    header('Location: index.php', true, 302);
    exit();
}

$genreId = (int)$_GET['genreId'];

$genre = null;

try {
    $genre = Genre::findById($genreId);
} catch(EntityNotFoundException) {
    http_response_code(404);
    exit("Genre non trouvé.");
}

$title = 'Jeux Vidéo : le genre';

$webPage = new AppWebPage($title);

$webPage->appendCssUrl('/css/style_page2.css');

$videoGames = GameCollection::findAll();

foreach($videoGames as $game) {
    $name = $game->getDescription();
    $id = $game->getPosterId();
    $correctLine = $webPage->escapeString($name);
    $webPage->appendContent("<p><a class='bouton' href='game_genre.php?Id={$id}'>{$correctLine}</a></p>");
}


echo $webPage->toHTML();