<?php
namespace models\concretes;

use global\Validate;
use model\abstract\AnonymousEntity;

class State extends AnonymousEntity {
    private String $name;
    private String $acronym;

    /**
     * @param String $acronym
     * @throws \Exception
     */
    public function __construct (string $acronym) {
        $this->acronym = Validate::state($acronym);
        $this->name = Validate::STATES[$acronym];
    }

    public function get_acronym (): string { return $this->acronym; }

    public function get_name (): string { return $this->name; }

    public function set_acronym (string $acronym): void {
        $this->acronym = Validate::STATES[$acronym];
        $this->name = Validate::STATES[$acronym];
    }
    
    public function equals ($object): boolean {
        if ($object instanceof State) {
            return $this->name === $object->get_name() && $this->acronym === $object->get_acronym();
        }
        return false;
    }

    public function __toString (): string { return $this->acronym; }
} // end class State Zipcode