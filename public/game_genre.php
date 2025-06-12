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
    $genreId = Genre::findById($genreId);
} catch(EntityNotFoundException) {
    http_response_code(404);
    exit("Genre non trouvé.");
}

$title = 'Jeux Vidéo : le genre';

$webPage = new AppWebPage($title);

echo $webPage->toHTML();