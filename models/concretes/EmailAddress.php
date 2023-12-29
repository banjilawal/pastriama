<?php
namespace models\concretes;

use Exception;
use exceptions\EmptyStringException;
use global\Validate;
use models\abstracts\Address;

require_once('vendor\autoload.php');

class EmailAddress extends Address {
    private string $mailbox;
    private Domain $domain;
    
    
    /**
     * @param string $mailbox
     * @param Domain $domain
     * @throws EmptyStringException
     * @throws Exception
     */
    public function __construct (string $mailbox, Domain $domain) {
        parent::__construct();
        $this->mailbox = Validate::non_empty_string($mailbox, 'EmailAddress', 'mailbox', 17);
        $this->domain = $domain;
    }
    
    public function getMailbox (): string {
        return $this->mailbox;
    }
    
    
    public function getDomain (): Domain {
        return $this->domain;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof EmailAddress) {
            return parent::equals($object)
                && $this->mailbox === $object->getMailbox()
                && $this->domain === $object->getDomain();
        }
        return false;
    }
    
    
    public function __toString (): string {
        return $this->mailbox . '@' . $this->domain;
    }
} // end class EmailAddress