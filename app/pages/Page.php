<?php

namespace app\pages;

use app\interfaces\Render;

abstract class Page {
    private string $title;
    private string $bodyHeading;
    private string $mainSectionHeading;
    private string $statusMessage;

    /**
     * @param string $title
     */
    public function __construct (string $title) {
        $this->title = $title;
        $this->statusMessage = '';
        $this->bodyHeading = '';
        $this->mainSectionHeading = '';
    }

    public function getTitle (): string {
        return $this->title;
    }

    public function getBodyHeading (): string {
        return $this->bodyHeading;
    }

    public function getMainSectionHeading (): string {
        return $this->mainSectionHeading;
    }

    public function getStatusMessage (): string {
        return $this->statusMessage;
    }

    public function setTitle (string $title): void {
        $this->title = $title;
    }

    public function setBodyHeading (string $bodyHeading): void {
        $this->bodyHeading = $bodyHeading;
    }

    public function setMainSectionHeading (string $mainSectionHeading): void {
        $this->mainSectionHeading = $mainSectionHeading;
    }

    public function setStatusMessage (string $statusMessage): void {
        $this->statusMessage = $statusMessage;
    }

    public abstract function mainSection (): string;
    public abstract function body (): string;
    public abstract function page (): string;

    public function encapsulate (string $tag, string $content, string $cssClass): string {
        return '<' . $tag . ' class="' . $cssClass . '">' . $content . '</' . $tag . '>';
    }
}