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

$WebPage->appendCssUrl('/css/style_page2.css');

$sort = $_GET['sort'] ?? 'title';
$validSorts = ['title', 'year'];
if (!in_array($sort, $validSorts)) {
    $sort = 'title';
}

$games = GameCollection::findByGenreId($genreId);

usort($games, function ($sortA, $sortB) use ($sort) {
    if ($sort === 'title') {
        return strcmp($sortA->getName(), $sortB->getName());
    } else {
        return $sortA->getReleaseYear() <=> $sortB->getReleaseYear();
    }
});

if ($sort === 'title') {
    $titleChecked = 'checked';
} else {
    $titleChecked = '';
}

if ($sort === 'year') {
    $yearChecked = 'checked';
} else {
    $yearChecked = '';
}

$WebPage->appendContent('<div class="section">');

$WebPage->appendContent('
    <form method="GET" class="sort-form">
        <input type="hidden" name="genreId" value="'. $genreId .'"/>
        <label><input type="radio" name="sort" value="title" '. ($titleChecked) .'> Trier par titre</label>
        <label><input type="radio" name="sort" value="year" '. ($yearChecked) .'> Trier par année</label>
        <button type="submit">Trier</button>
    </form>
');

$WebPage->appendContent('<div class="list">');

foreach ($games as $game) {
    $id = $game->getId();
    $posterId = $game->getPosterId();
    $name = $WebPage->escapeString($game->getName());
    $year = $game->getReleaseYear();
    $description = $game->getShortDescription();

    $WebPage->appendContent(
        "<a class='item-link' href='VideoGame.php?gameId={$id}'>
            <div class='game-item'>
                <div class='game-poster'>
                    <img class='poster' src='poster.php?posterId={$posterId}' alt='Poster de {$name}'/>
                </div>
                <div class='game-info'>
                    <h4>{$name} ({$year})</h4>  
                    <p>{$description}</p>
                </div>
            </div>
        </a>"
    );
}

$WebPage->appendContent('</div></div>');

echo $WebPage->toHTML();