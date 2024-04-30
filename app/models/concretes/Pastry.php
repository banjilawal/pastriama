<?php declare(strict_types=1);
namespace app\models\concretes;

use app\models\abstracts\Product;

class Pastry extends Product {

    public function __construct (
        int $id,
        string $name,
        string $description,
        string $imageName,
        float $price
    ) {
        parent::__construct (
            $id,
            $name,
            $description,
            $imageName,
            $price
        );
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Pastry) {
            return parent::equals($object);
        }
        return false;
    }

//    public function __toString (): string {
//        return 'id: ' . $this->getId()
//            . ' name:' . $this->getName()
//            . ' price:' . number_format($this->getPrice(), 2)
//            . ' description:' . $this->getDescription();
//    }
}