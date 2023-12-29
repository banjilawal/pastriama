<?php
namespace models\concretes;

use exceptions\EmptyStringException;
use global\Validate;

require_once('vendor\autoload.php');

class Domain {
    private string $name;
    private string $tld;
    
    
    /**
     * @throws EmptyStringException
     */
    public function __construct (string $name, string $tld) {
        $this->name = Validate::non_empty_string($name, 'Domain', 'name', 14);
        $this->tld = Validate::non_empty_string($tld, 'Domain', 'tld', 14);
    }
    public function getName (): string {
        return $this->name;
    }
    
    
    public function getTLD (): string {
        return $this->tld;
    }
    
    
    /**
     * @throws EmptyStringException
     */
    public function setName (string $name): void {
        $this->name = Validate::non_empty_string($name, 'Domain', 'name', 14);
    }
    
    
    
    /**
     * @throws EmptyStringException
     */
    public function setTLD (string $tld): void {
        $this->tld = Validate::non_empty_string($tld, 'Domain', 'tld', 14);
    }
    
    
    public function equals ($object): bool {
        if ($object instanceof Domain) {
            return $this->name === $object->getName() && $this->tld === $object->getTLD();
        }
        return false;
    }

    
    public function __toString (): string {
        return $this->name . '\.' . $this->tld;
    }
}