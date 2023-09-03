<?php
namespace exceptions;
use ReturnTypeWillChange;
use Throwable;

require_once('bootstrap.php');

abstract class EntityException extends \Exception {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
} // end Exception EntityException
?>