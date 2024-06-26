<?php declare(strict_types=1);

namespace pages;
require_once 'bootstrap.php';

abstract class Page {
    private string $title;

    /**
     * @param string $title
     */
    public function __construct (string $title) {
        $this->title = $title;
    }

    public function getTitle (): string {
        return $this->title;
    }

    public function setTitle (string $title): void {
        $this->title = $title;
    }
}