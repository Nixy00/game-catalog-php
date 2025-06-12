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

$webPage = new AppWebPage();
$name = $webPage->escapeString($genre->getDescription());

$webPage->setTitle("Jeux vidéo :" . $name);
$webPage->appendCssUrl('/css/style_page2.css');

$videoGames = GameCollection::findByGenreId($genreId);

foreach($videoGames as $game) {
    $game_name = $webPage->escapeString($game->getName());
    $year = $game->getReleaseYear();
    $game_description = $webPage->escapeString($game->getShortDescription());
    $webPage->appendContent(
        <<<HTML
        <a class="game" href="game.php?gameId={$game->getId()}">
        <h2>{$game_name} ({$year})</h2>
            <p>{$game_description}</p>
        </a>      
HTML);


}


echo $webPage->toHTML();