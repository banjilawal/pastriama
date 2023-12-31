<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\StoreItem;

class Pastry extends StoreItem {

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

    public function __toString (): string {
        return parent::__toString();
    }
}