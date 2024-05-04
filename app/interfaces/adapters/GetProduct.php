<?php

namespace app\interfaces\adapters;

use app\models\abstracts\Product;

interface GetProduct extends GetName {

    public function getProduct (): Product;

}