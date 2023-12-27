<?php
namespace models\concretes;

use Exception;
use global\Validate;

class State {
    private String $name;
    private String $acronym;

    /**
     * @param String $acronym
     * @throws Exception
     */
    public function __construct (string $acronym) {
        $this->acronym = Validate::state($acronym);
        $this->name = Validate::STATES[$acronym];
    }

    public function getAcronym (): string { return $this->acronym; }

    public function getName (): string { return $this->name; }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof State) {
            return $this->name === $object->getName() && $this->acronym === $object->getAcronym();
        }
        return false;
    }

    public function __toString (): string { return $this->acronym; }
} // end class State Zipcode