<?php
namespace models\interfaces;

interface Nameable {
    public function get_name (): string;
    public function set_name (string $name): void;
} // end interface Nameable