<?php declare(strict_types=1);
namespace exceptions;

class EmptyStringException extends EntityException {
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code, null);
    } // close constructor
} // end Exception EmptyStringException
?>