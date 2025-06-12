<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use html\AppWebPage;

$title = 'Jeux Vidéo : le genre';

$webPage = new AppWebPage($title);

echo $webPage->toHTML();