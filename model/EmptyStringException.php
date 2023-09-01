<?php declare(strict_types=1);

    require_once('EntityException.php');

    class EmptyStringException extends Exception {    
        public function __construct($message, $code = 0) {
            parent::__construct($message, $code, null);
        } // close constructor
    } // end Exception EmptyStringException
?>