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

$WebPage->appendContent('<div class="section">');
$WebPage->appendContent('<div class="list">');

foreach (GameCollection::findByCategoryId($categoryId) as $game) {
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