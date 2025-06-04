<?php

declare(strict_types=1);

use html\WebPage;

$webPage = new WebPage('SAE 2-01');

$webPage->appendContent("<h1>C'est un premier index pour la SAE Dev d'application</h1>");

echo $webPage->toHTML();