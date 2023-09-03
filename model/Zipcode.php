<?php

namespace model;

use Exception;
use global\Validate;

class Zipcode {
    private string $zip_code;
    
    /**
     * @param string $zip_code
     * @throws Exception
     */
    public function __construct (string $zip_code) {
        $this->zip_code = Validate::zip_code($zip_code, 'Zipcode', 'zip_code', 15);
    }
    
    public function get_zip_code (): string {
        return $this->zip_code;
    }
    
    /**
     * @throws Exception
     */
    public function set_zip_code (string $zip_code): void {
        $this->zip_code = Validate::zip_code($zip_code, 'Zipcode', 'zip_code', 27);
    }
    
    public function __toString (): string {
        return 'zip-code:' . $this->zip_code;
    }
    
}