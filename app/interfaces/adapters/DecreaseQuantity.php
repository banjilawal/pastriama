<?php

namespace app\interfaces\adapters;

use app\models\abstracts\Product;

interface DecreaseQuantity extends GetQuantity {

    public function decreaseQuantity (int $amount): void;
}