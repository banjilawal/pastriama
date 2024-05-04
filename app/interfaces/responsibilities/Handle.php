<?php declare(strict_types=1);

namespace app\interfaces\responsibilities;

use app\requests\Request;

interface Handle {

    public function handle (& $array, Request $request): bool;
    public function setNext (Handle $handler): void;
}