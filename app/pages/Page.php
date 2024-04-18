<?php

namespace app\pages;

use app\interfaces\Renderable;

abstract class Page implements Renderable {
    private string $title;
    private string $statusMessage;

    /**
     * @param string $title
     */
    public function __construct (string $title) {
        $this->title = $title;
        $this->statusMessage = '';
    }

    public function getTitle (): string {
        return $this->title;
    }

    public function getStatusMessage (): string {
        return $this->statusMessage;
    }

    public function setTitle (string $title): void {
        $this->title = $title;
    }

    public function setStatusMessage (string $statusMessage): void {
        $this->statusMessage = $statusMessage;
    }
}