<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use html\Form\GameForm;

try {
    $gameForm = new GameForm(null);
    $gameForm->setEntityFromQueryString();

    $gameForm->getGame()->save();
    header('Location: /index.php');

} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
