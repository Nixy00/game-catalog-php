<?php

namespace html;

/**
 *
 */
class WebPage
{
    /**
     * @var string
     */
    private string $head = "";
    /**
     * @var string
     */
    private string $title = "";
    /**
     * @var string
     */
    private string $body = "";

    /**
     * @param string $head
     * @param string $title
     * @param string $body
     */
    public function __construct(string $title = "")
    {
        $this->head = "";
        $this->title = $title;
        $this->body = "";
    }

    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return void
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * @param string $css
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->head .= <<<HTML
        <style>
            $css
        </style>
        HTML;
    }

    /**
     * @param string $url
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->head .= <<<HMTL
        <link rel='stylesheet' href='$url'>
        HMTL;
    }

    /**
     * @param string $js
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->head .= <<<HTML
        <script>
            $js
        </script>
        HTML;
    }

    /**
     * @param string $url
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->head .= <<<HMTL
        <script src="$url"></script>
        HMTL;
    }

    /**
     * @param string $content
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * @param string $string
     * @return string
     */
    public function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * @return string
     */
    public function toHTML()
    {
        return <<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>$this->title</title>
                $this->head
            </head>
            <body>
                $this->body
            </body>
        </html>
        HTML;

    }

    /**
     * @return string
     */
    public function getLastModification()
    {
        date_default_timezone_set('Europe/Paris');
        return date("F d Y H:i:s.", getlastmod());
    }
}
