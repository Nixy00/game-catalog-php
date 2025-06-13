<?php

declare(strict_types=1);

use Entity\Game;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;

try {
    if (empty($_GET['gameId']) || !is_numeric($_GET['gameId'])) {
        throw new ParameterException("'gameId' ne doit pas être vide et doit être de type numérique.");
    }

    $gameId = (int) $_GET['gameId'];
    $game = Game::findById($gameId);

    $game->delete();
    header('Location: /index.php');

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
