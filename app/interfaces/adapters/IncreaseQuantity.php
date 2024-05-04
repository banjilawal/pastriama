<?php

namespace app\interfaces\adapters;


interface IncreaseQuantity extends GetQuantity {
    public function increaseQuantity (int $amount): void;
}