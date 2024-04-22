<?php declare(strict_types=1);

namespace app\models\abstracts;

use app\enums\Status;
use app\interfaces\Equality;

abstract class Entity extends Model implements Equality {
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