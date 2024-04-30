<?php declare(strict_types=1);

namespace app\models\abstracts;

use Exception;

abstract class NamedEntity extends Entity {
    private string $name;


    public function __construct (int $id, string $name) {
        parent::__construct($id);
        $this->name = $name;
    }

    public function getName (): string {
        return $this->name;
    }

    public function setName (string $name): void {
        $this->name = $name;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof NamedEntity) {
            return parent::equals($object) && $this->name === $object->getName();
        }
        return false;
    }

    public function __toString (): string  {
        return parent::__toString() . ' name:' . $this->name;
    }
}