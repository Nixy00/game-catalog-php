<?php

declare(strict_types=1);

use Entity\Game;
use Entity\Developer;
use html\AppWebPage;

$webPage = new AppWebPage();
$webPage->appendCssUrl('/css/style_page3.css');

$gameId = (int) $_GET['gameId'];
$game = Game::findById($gameId);

$posterId = $game->getPosterId();
$title = $game->getName();
$webPage->setTitle('Jeu Vidéo - ' . $title);

$webPage->appendContent("<div class='game-info'>");

$webPage->appendContent("<div class='game-header'>");
$webPage->appendContent("<img class='poster' src='poster.php?posterId={$posterId}' alt='Poster de la série {$webPage->escapeString($title)}'/>");

$webPage->appendContent("<div class='platform-date'>");

$webPage->appendContent("<div class='platform-logos'>");
if ($game->getMac() === 1) {
    $webPage->appendContent("<img class='img' src='img/apple.svg' alt='logo apple'>");
}
if ($game->getLinux() === 1) {
    $webPage->appendContent("<img class='img' src='img/linux.svg' alt='logo linux'>");
}
if ($game->getWindows() === 1) {
    $webPage->appendContent("<img class='img' src='img/windows.svg' alt='logo windows'>");
}
$webPage->appendContent("</div>");

$webPage->appendContent("<p class='release-year'>Sortie : {$game->getReleaseYear()}</p>");
$webPage->appendContent("</div>");

if($game->getDeveloperId() !== null){
    $developer = Developer::findById($game->getDeveloperId());
    if($developer !== null){
        $dev = $developer->getName();
    }
    else{
        $dev = 'Non renseigné';
    }
}
else{
    $dev = 'Non renseigné';
}

$webPage->appendContent("<p>Développeur : {$dev}</p>");
$webPage->appendContent("</div>");

$webPage->appendContent("<div class='game-details'>");

$score = $game->getMetacritic();

if($score !== null){
    $score = "{$score}/100";
}
else{
    $score = "Pas de note";
}

$price = $game->getPrice() / 100;

if($price == 0){
    $price = 'Gratuit';
}
else{
    $price = $game->getPrice() / 100 . '€';
}

$webPage->appendContent("<div class='note-price'>
    <p>Note : {$score}</p>
    <p>Prix : {$price}</p>
</div>");

$webPage->appendContent("<div class='game-description'>{$game->getShortDescription()}</div>");
$webPage->appendContent("</div>");
$webPage->appendContent("</div>");

$webPage->appendContent("<div class='game'><div class='game-tags'>");

$categories = $game->getAllCategory();
$webPage->appendContent("<div><h2>Catégories :</h2><p>");
foreach ($categories as $category) {
    $name = $category->getDescription();
    $id = $category->getId();
    $webPage->appendContent("<a class='bouton' href='game_category.php?categoryId={$id}'>{$name}</a> ");
}
$webPage->appendContent("</p></div>");

$genres = $game->getAllGenres();
$webPage->appendContent("<div><h2>Genres :</h2><p>");
foreach ($genres as $genre) {
    $name = $genre->getDescription();
    $id = $genre->getId();
    $webPage->appendContent("<a class='bouton' href='game_genre.php?genreId={$id}'>{$name}</a> ");
}
$webPage->appendContent("</p></div>");

$webPage->appendContent("</div></div>");

echo $webPage->toHTML();