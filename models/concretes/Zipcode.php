<?php
namespace models\concretes;

use Exception;
use global\Validate;

class Zipcode {
    private string $zipcode;
    
    
    /**
     * @param string $zipcode
     * @throws Exception
     */
    public function __construct (string $zipcode) {
        $this->zipcode = Validate::zip_code($zipcode, 'Zipcode', 'zip_code', 15);
    }
    
    
    public function getZipcode (): string {
        return $this->zipcode;
    }
    
    
    /**
     * @throws Exception
     */
    public function setZipcode (string $zipcode): void {
        $this->zipcode = Validate::zip_code($zipcode, 'Zipcode', 'zip_code', 24);
    }
    
    public function equals ($object): bool {
        if ($object instanceof Zipcode) {
            return $this->zipcode === $object->getZipcode();
        }
        return false;
    }
    
    public function __toString (): string {
        return 'zipcode:' . $this->zipcode;
    }
} // end class Zipcode