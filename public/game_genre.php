<?php

declare(strict_types=1);

use Entity\Collection\GameCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Genre;
use html\AppWebPage;

if (!isset($_GET['genreId']) || !ctype_digit($_GET['genreId'])) {
    echo "Paramètre 'id' manquant ou invalide.";
    exit;
}

$genreId = (int) $_GET['genreId'];

try {
    $genre = Genre::findById($genreId);
} catch (EntityNotFoundException) {
    echo "Genre non trouvée pour l'ID : $genreId";
    exit;
}


$WebPage = new AppWebPage();
$title = $WebPage->escapeString($genre->getDescription());
$WebPage->setTitle('Jeux vidéo : ' . $title);

$WebPage->appendCssUrl('/css/style_page1.css');

$WebPage->appendContent('<div class="section">');
$WebPage->appendContent('<h2 class="section-title">Genres</h2>');
$WebPage->appendContent('<div class="list">');

foreach (GameCollection::findByGenreId($genreId) as $game) {
    $id = $game->getId();
    $posterId = $game->getPosterId();
    $name = $WebPage->escapeString($game->getName());
    $year = $game->getReleaseYear();
    $description = $game->getShortDescription();

    $WebPage->appendContent(
        "<a class='item-link' href='VideoGame.php?gameId={$id}'>
                    <img class='poster' src='poster.php?posterId={$posterId}' alt='Poster de la série {$WebPage->escapeString($game->getName())}'/>
                    <h4>{$name} ({$year})</h4>  
                    <p>{$description}</p>
                 </a>"
    );
}

$WebPage->appendContent('</div></div>');

echo $WebPage->toHTML();