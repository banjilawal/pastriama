<?php declare(strict_types=1);

namespace app\models\abstracts;

use app\enums\Status;

abstract class Entity extends Model {
    private int $id;
    private Status $staus;

    /**
     * @param int $id
     */
    public function __construct (int $id) {
        parent::__construct();
        $this->id = $id;
        $this->staus = Status::ENABLED;
    }

    public function getId (): int {
        return $this->id;
    }

    public function getStatus (): Status {
        return $this->getStatus();
    }

    public function setId (int $id): void {
        $this->id = $id;
    }

    public function setStatus (Status $status): void {
        $this->staus = $status;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Entity) {
            return $this->id === $object->getId() && $this->staus === $object->getStatus();
        }
        return false;
    }

    public function __toString (): string {
        return ' id:' . $this->id;
    }
}