<?php declare(strict_types=1);
namespace model\abstracts;

use exceptions\EmptyStringException;
use global\Validate;

abstract class NamedEntity extends Entity {
    private String $name;

    public function __construct (int $id, String $name) {
        parent::__construct($id);
        $this->name = Validate::non_empty_string($name, 'NamedEntity', 'name', 11);
    }
    

    public function getName (): string {
        return $this->name;
    }
    

    /**
     * @throws EmptyStringException
     */
    public function setName (string $name): void {
        $this->name = Validate::non_empty_string($name, 'NamedEntity', 'name', 11);
    }
    
    public function equals ($object): bool {
        if ($object instanceof NamedEntity) {
            return parent::equals($object) && $this->name === $object->getName();
        }
        return false;
    }

    public function __toString (): string {
        return parent::__toString() . ' name:' . $this->name;
    }
} // end class NamedEntity