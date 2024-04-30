<?php declare(strict_types=1);
namespace app\models\concretes;

use app\interfaces\Quantifiable;
use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;

use app\models\catalogs\NewInventory;
use Exception;

class OrderItem extends StoreItem implements Quantifiable {

    /**
     * @param Product $product
     * @param int $quantity
     * @throws Exception
     */
    public function __construct (Product $product, int $quantity) {
        parent::__construct($product, $quantity);
    }

    /**
     * @throws Exception
     */
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof OrderItem)
            return  parent::equals($object);
        return false;
    }
}