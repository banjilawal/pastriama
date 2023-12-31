<?php declare(strict_types=1);

namespace app\models\abstracts;

abstract class Entity extends Model {
    private int $id;

    /**
     * @param int $id
     */
    public function __construct (int $id) {
        parent::__construct();
        $this->id = $id;
    }

    public function getId (): int {
        return $this->id;
    }

    public function setId (int $id): void {
        $this->id = $id;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Entity) {
            return $this->id === $object->getId();
        }
        return false;
    }

    public function __toString (): string {
        return ' id:' . $this->id;
    }
}