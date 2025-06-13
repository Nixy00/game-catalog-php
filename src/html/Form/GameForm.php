<?php

declare(strict_types=1);

namespace html\Form;

use Entity\Exception\ParameterException;
use Entity\Game;
use html\StringEscaper;

class GameForm
{
    use StringEscaper;
    private ?Game $game;

    public function __construct(?Game $game)
    {
        $this->game = $game;
    }
    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setEntityFromQueryString(): void
    {
        if (!empty($_POST['id']) && ctype_digit($_POST['id'])) {
            $id = intval($_POST['id']);
        } else {
            $id = null;
        }

        if (!empty($_POST['name'])) {
            $name = $this->escapeString($this->stripTagsAndTrim($_POST['name']));
        } else {
            throw new ParameterException("Nom vide");
        }

        if (!empty($_POST['releaseYear'])) {
            $releaseYear = $this->escapeString($this->stripTagsAndTrim($_POST['releaseYear']));
        } else {
            throw new ParameterException("Date vide");
        }

        if (!empty($_POST['shortDescription'])) {
            $shortDescription = $this->escapeString($this->stripTagsAndTrim($_POST['shortDescription']));
        } else {
            throw new ParameterException("Description vide");
        }

        if (!empty($_POST['windows'])) {
            $windows = $this->escapeString($this->stripTagsAndTrim($_POST['windows']));
        } else {
            throw new ParameterException("Windows vide");
        }

        if (!empty($_POST['linux'])) {
            $linux = $this->escapeString($this->stripTagsAndTrim($_POST['linux']));
        } else {
            throw new ParameterException("Linux vide");
        }

        if (!empty($_POST['mac'])) {
            $mac = $this->escapeString($this->stripTagsAndTrim($_POST['mac']));
        } else {
            throw new ParameterException("Mac vide");
        }

        if (!empty($_POST['posterId']) && ctype_digit($_POST['posterId'])) {
            $posterId = intval($_POST['posterId']);
        } else {
            $posterId = null;
        }

        $this->game = Game::create($name, (int) $releaseYear, $shortDescription, (int) $windows, (int) $linux, (int) $mac, $posterId, $id);

        return;
    }

    public function getHtmlForm(string $action): string
    {
        return <<<HTML
        <h1>{$this->game?->getName()}</h1>
            <form method="post" action="{$action}">
                <input name="id" type="hidden" value="{$this->game?->getId()}">
                
                    <div class="F_name">
                        <label for="nom">Nom: </label>
                        <input name="name" type="text" value="{$this->escapeString($this->game?->getName())}" required>
                    </div>
                    
                    <div class="F_releaseYear">
                        <label for="releaseYear">Date de sortie : </label>
                        <input name="releaseYear" type="text" value="{$this->game?->getReleaseYear()}" required>
                    </div>
                    
                    <div class="F_shortDesc">
                        <label for="description">Homepage: </label>
                        <input name="shortDesc" type="text" value="{$this->escapeString($this->game?->getShortDescription())}" required>
                    </div>
                    
                    <div class="F_windows">
                        <label for="windows">Windows : </label>
                        <input name="windows" type="button" value="{$this->game?->getWindows()}" required>
                    </div>
                    <div class="F_linux">
                    
                        <label for="linux">Linux : </label>
                        <input name="linux" type="button" value="{$this->game?->getLinux()}" required>
                    </div>
                    <div class="F_mac">
                        <label for="mac">Mac : </label>
                        <input name="mac" type="button" value="{$this->game?->getMac()}" required>
                    </div>
                    <div class="F_developer">
                        <input name="developerId" type="hidden" value="{$this->game?->getDeveloperId()}">
                    </div>
                    <div class="F_poster">
                        <input name="posterId" type="hidden" value="{$this->game?->getPosterId()}">
                    </div>
                <button type="submit">Enregistrer</button>
            </form>
HTML;
    }
}