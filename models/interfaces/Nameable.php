<?php
namespace models\interfaces;

interface Nameable {
    public function getName (): string;
    public function setName (string $name): void;
} // end interface Nameable