<?php

namespace app\interfaces\adapters;

interface Equality {
    public function equals (Object $object): bool;
}