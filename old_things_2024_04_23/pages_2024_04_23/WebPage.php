<?php declare(strict_types=1);

namespace old_things_2024_04_23\pages_2024_04_23;
require_once 'bootstrap.php';

abstract class WebPage {
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