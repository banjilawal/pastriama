<?php

namespace app\handlers;

use app\interfaces\responsibilities\Handle;
use app\requests\Request;

abstract class Handler implements Handle {

    protected Handle $next;

    public function handle (& $array, Request $request): bool {
        if ($this->next) {
            return $this->next->handle($array, $request);
        }
        return false;
    }

    public function setNext (Handle $handler): void {
        $this->next = $handler;
    }
}