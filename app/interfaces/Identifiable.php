<?php

namespace app\interfaces;

interface Identifiable {
    public function getId(): int;
    public function setId(int $id): void;
}