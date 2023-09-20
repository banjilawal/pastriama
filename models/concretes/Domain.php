<?php
namespace models\concretes;

use exceptions\EmptyStringException;
use global\Validate;
use model\abstract\AnonymousEntity;
use models\interfaces\Nameable;

class Domain extends AnonymousEntity implements Nameable {
    private string $name;
    private string $tld;
    
    /**
     * @throws EmptyStringException
     */
    public function __construct (string $name, string $tld) {
        $this->name = Validate::non_empty_string($name, 'Domain', 'name', 14);
        $this->tld = Validate::non_empty_string($tld, 'Domain', 'tld', 14);
    }
    public function get_name (): string { return $this->name; }
    
    public function get_tld (): string { return $this->tld; }
    
    /**
     * @throws EmptyStringException
     */
    public function set_name (string $name): void {
        $this->name = Validate::non_empty_string($name, 'Domain', 'name', 14);
    }
    
    
    public function equals ($object): boolean {
        if ($object instanceof Domain) {
            return parent::equals($object) && $this->name === $object->get_name() && $this->tld === $object->get_tld();
        }
        return false;
    }
    
    /**
     * @throws EmptyStringException
     */
    public function set_tld (string $tld): void {
        $this->tld = Validate::non_empty_string($tld, 'Domain', 'tld', 14);
    }
    
    public function __toString (): string {
        return $this->name . '\.' . $this->tld;
    }
}