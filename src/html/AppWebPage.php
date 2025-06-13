<?php

declare(strict_types=1);

namespace html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = '')
    {
        parent::__construct($title);
    }
    public function toHTML(): string
    {
        return <<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
            <header class="header">
                <h1>{$this->getTitle()}</h1>
                <a href="index.php"><img class="home" src="img/house-chimney-solid.svg" alt="Retour vers la page principale"></a>
                <a href="game-form.php"><img class="home" src="img/folder-plus-solid.svg" alt="Ajout d'un jeu"></a>
            </header>
            <div class="content">
                {$this->getBody()}
            </div>
            <footer class="footer">
                <p>Dernière modification : {$this->getLastModification()}</p>
            </footer>
            </body>
        </html>
HTML;
    }
}