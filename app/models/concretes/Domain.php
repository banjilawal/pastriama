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
        $this->name = trim($name, ' ');
        $this->tld = trim($tld, ' ');
    }

    public function getName (): string {
        return $this->name;
    }

    public function getTld (): string {
        return trim($this->tld, ' ');
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
        return $this->getName() . '.' . $this->getTld();
    }
}