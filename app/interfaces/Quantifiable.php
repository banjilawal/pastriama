<?php

namespace app\interfaces;

use app\models\abstracts\Product;

interface Quantifiable {

    public function getProduct (): Product;
    public function getQuantity (): int;
    public function getCost (): float;
    public function equals ($object): bool;
    public function decreaseQuantity (int $amount): void;
    public function increaseQuantity (int $amount): void;

}