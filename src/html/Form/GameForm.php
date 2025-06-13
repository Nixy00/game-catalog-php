<?php

declare(strict_types=1);

namespace html\Form;

use Entity\Exception\ParameterException;
use Entity\Game;
use Entity\Developer;
use html\StringEscaper;

class GameForm
{
    use StringEscaper;

    private ?Game $game;
    /** @var Developer[] */
    private array $developers;

    /**
     * @param Developer[] $developers
     */
    public function __construct(?Game $game, array $developers = [])
    {
        $this->game = $game;
        $this->developers = $developers;
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

        if (!empty($_POST['shortDesc'])) {
            $shortDescription = $this->escapeString($this->stripTagsAndTrim($_POST['shortDesc']));
        } else {
            throw new ParameterException("Description vide");
        }

        if (isset($_POST['windows']) && in_array($_POST['windows'], ['0', '1'], true)) {
            $windows = $this->escapeString($this->stripTagsAndTrim($_POST['windows']));
        } else {
            throw new ParameterException("Windows vide");
        }

        if (isset($_POST['linux']) && in_array($_POST['linux'], ['0', '1'], true)) {
            $linux = $this->escapeString($this->stripTagsAndTrim($_POST['linux']));
        } else {
            throw new ParameterException("Linux vide");
        }

        if (isset($_POST['mac']) && in_array($_POST['mac'], ['0', '1'], true)) {
            $mac = $this->escapeString($this->stripTagsAndTrim($_POST['mac']));
        } else {
            throw new ParameterException("Mac vide");
        }

        if (isset($_POST['price']) && is_numeric($_POST['price'])) {
            $price = floatval($_POST['price']);
        } else {
            throw new ParameterException("Prix invalide");
        }

        if (isset($_POST['score']) && ctype_digit($_POST['score'])) {
            $score = intval($_POST['score']);
            if ($score < 0 || $score > 100) {
                throw new ParameterException("Note doit être entre 0 et 100");
            }
        } else {
            throw new ParameterException("Note invalide");
        }

        if (!empty($_POST['developerId']) && ctype_digit($_POST['developerId'])) {
            $developerId = intval($_POST['developerId']);
        } else {
            $developerId = null;
        }

        $posterId = null;
        if (isset($_FILES['posterFile']) && $_FILES['posterFile']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['posterFile']['tmp_name'];
            $fileType = mime_content_type($fileTmpPath);

            $allowedMimeTypes = ['image/jpeg', 'image/pjpeg'];
            if (!in_array($fileType, $allowedMimeTypes, true)) {
                throw new ParameterException("Le poster doit être un fichier JPEG.");
            }

            $imageData = file_get_contents($fileTmpPath);
            if ($imageData === false) {
                throw new ParameterException("Impossible de lire le fichier poster.");
            }

            $posterId = base64_encode($imageData);

        } elseif (!empty($_POST['posterId'])) {
            $posterId = $_POST['posterId'];
        }

        $this->game = Game::create(
            $name,
            (int) $releaseYear,
            $shortDescription,
            (int) $windows,
            (int) $linux,
            (int) $mac,
            $posterId,
            $price,
            $score,
            $developerId,
            $id
        );
    }

    public function getHtmlForm(string $action): string
    {
        $windowsCheckedYes = ($this->game?->getWindows() == 1) ? 'checked' : '';
        $windowsCheckedNo = ($this->game?->getWindows() == 0) ? 'checked' : '';

        $linuxCheckedYes = ($this->game?->getLinux() == 1) ? 'checked' : '';
        $linuxCheckedNo = ($this->game?->getLinux() == 0) ? 'checked' : '';

        $macCheckedYes = ($this->game?->getMac() == 1) ? 'checked' : '';
        $macCheckedNo = ($this->game?->getMac() == 0) ? 'checked' : '';

        $posterIdValue = $this->game?->getPosterId() ?? '';

        $priceValue = $this->game?->getPrice() ?? '';
        $scoreValue = $this->game?->getScore() ?? '';

        $developerIdSelected = $this->game?->getDeveloperId() ?? null;

        $options = '';
        foreach ($this->developers as $dev) {
            $selected = ($dev->getId() === $developerIdSelected) ? 'selected' : '';
            $nameEscaped = $this->escapeString($dev->getName());
            $options .= "<option value=\"{$dev->getId()}\" $selected>$nameEscaped</option>";
        }

        return <<<HTML
<h1>{$this->escapeString($this->game?->getName() ?? '')}</h1>
<form method="post" action="{$action}" enctype="multipart/form-data">
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
        <label for="description">Description Courte: </label>
        <input name="shortDesc" type="text" value="{$this->escapeString($this->game?->getShortDescription())}" required>
    </div>

    <div class="F_windows">
        <label>Windows : </label>
        <input type="radio" name="windows" id="windows_yes" value="1" $windowsCheckedYes> <label for="windows_yes">Oui</label>
        <input type="radio" name="windows" id="windows_no" value="0" $windowsCheckedNo> <label for="windows_no">Non</label>
    </div>

    <div class="F_linux">
        <label>Linux : </label>
        <input type="radio" name="linux" id="linux_yes" value="1" $linuxCheckedYes> <label for="linux_yes">Oui</label>
        <input type="radio" name="linux" id="linux_no" value="0" $linuxCheckedNo> <label for="linux_no">Non</label>
    </div>

    <div class="F_mac">
        <label>Mac : </label>
        <input type="radio" name="mac" id="mac_yes" value="1" $macCheckedYes> <label for="mac_yes">Oui</label>
        <input type="radio" name="mac" id="mac_no" value="0" $macCheckedNo> <label for="mac_no">Non</label>
    </div>

    <div class="F_price">
        <label for="price">Prix (€) : </label>
        <input name="price" type="number" step="0.01" min="0" value="$priceValue" required>
    </div>

    <div class="F_score">
        <label for="score">Note (/100) : </label>
        <input name="score" type="number" min="0" max="100" value="$scoreValue" required>
    </div>

    <div class="F_developer">
        <label for="developerId">Développeur : </label>
        <select name="developerId" id="developerId" required>
            <option value="">-- Choisir un développeur --</option>
            $options
        </select>
    </div>

    <div class="F_poster">
        <label for="posterFile">Poster (JPEG) : </label>
        <input type="file" name="posterFile" accept="image/jpeg">
        <input name="posterId" type="hidden" value="$posterIdValue">
    </div>

    <button type="submit">Enregistrer</button>
</form>
HTML;
    }
}
