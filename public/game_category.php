<?php

declare(strict_types=1);

use Entity\Collection\GameCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Category;
use html\AppWebPage;

if (!isset($_GET['categoryId']) || !ctype_digit($_GET['categoryId'])) {
    echo "Paramètre 'id' manquant ou invalide.";
    exit;
}

$categoryId = (int) $_GET['categoryId'];

try {
    $category = Category::findById($categoryId);
} catch (EntityNotFoundException) {
    echo "Catégorie non trouvée pour l'ID : $categoryId";
    exit;
}

$WebPage = new AppWebPage();

$title = $WebPage->escapeString($category->getDescription());
$WebPage->setTitle('Jeux vidéo : ' . $title);

$WebPage->appendCssUrl('/css/style_page2.css');

$sort = $_GET['sort'] ?? 'title';
$validSorts = ['title', 'year'];
if (!in_array($sort, $validSorts)) {
    $sort = 'title';
}


$games = GameCollection::findByCategoryId($categoryId);

usort($games, function ($a, $b) use ($sort) {
    if ($sort === 'title') {
        return strcmp($a->getName(), $b->getName());
    } else {
        return $a->getReleaseYear() <=> $b->getReleaseYear();
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
        <input type="hidden" name="categoryId" value="'. $categoryId .'"/>
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