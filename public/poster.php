<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Poster;

try {
    $poster = Poster::findById(intval($_GET['posterId']));
    header('Content-Type: image/jpeg');
    echo $poster->getJpeg();

} catch (ParameterException | EntityNotFoundException) {
    header('Location: ./images/default.png');
}