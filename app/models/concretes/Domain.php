<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Model;

class Domain extends Model {
    private string $name;
    private string $tld;

    /**
     * @param string $name
     * @param string $tld
     */
    public function __construct (string $name, string $tld) {
        parent::__construct();
        $this->name = $name;
        $this->tld = $tld;
    }

    public function getName (): string {
        return $this->name;
    }

    public function getTld (): string {
        return $this->tld;
    }

    public function setName (string $name): void {
        $this->name = $name;
    }

    public function setTld (string $tld): void {
        $this->tld = $tld;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Domain) {
            return parent::equals($object)
            && $this->name === $object->getName()
            && $this->tld === $object->getTLD();
        }
        return false;
    }

    public function __toString (): string {
        return parent::__toString() . $this->getName() . '\.' . $this->getTld();
    }
}