<?php

declare(strict_types=1);

use Entity\Exception\ParameterException;
use Entity\Game;
use Entity\Exception\EntityNotFoundException;
use html\AppWebPage;
use html\Form\GameForm;

try {
    $game = null;

    if (isset($_GET['gameId'])) {
        if (!is_numeric($_GET['gameId'])) {
            throw new ParameterException("'gameId' n'est pas de type numérique.");
        }

        $gameId = (int) $_GET['gameId'];
        $game = Game::findById($gameId);
    }
    $gameForm = new GameForm($game);
    $appWebPage = new AppWebPage("Création d'un Jeu");
    $appWebPage->appendCssUrl('css/style_formulaire.css');
    $appWebPage->appendContent($gameForm->getHtmlForm("game-save.php"));

    echo $appWebPage->toHTML();

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
