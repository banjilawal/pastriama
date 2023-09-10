<?php
namespace models\concretes;

use exceptions\EmptyStringException;
use global\Validate;
use model\abstract\Address;

class EmailAddress extends Address {
    private string $mailbox;
    private Domain $domain;
    
    /**
     * @param string $mailbox
     * @param Domain $domain
     * @throws EmptyStringException
     * @throws \Exception
     */
    public function __construct (int $id, string $mailbox, Domain $domain) {
        parent::__construct($id);
        $this->mailbox = Validate::non_empty_string($mailbox, 'EmailAddress', 'mailbox', 17);
        $this->domain = $domain;
    }
    
    public function get_mailbox (): string { return $this->mailbox; }
    public function get_domain (): Domain { return $this->domain; }
    
    /**
     * @throws EmptyStringException
     */
    public function set_mailbox (string $mailbox): void {
        $this->mailbox = Validate::non_empty_string($mailbox, 'EmailAddress', 'mailbox', 30);
    }
    
    
    public function set_domain (Domain $domain): void {
        $this->domain = $domain;
    }
    
    
    public function equals ($object): boolean {
        if ($object instanceof EmailAddress) {
            return parent::equals($object)
                && $this->mailbox === $object->get_mailbox()
                && $this->domain === $object->get_domain();
        }
        return false;
    }
    public function __toString (): string { return $this->mailbox . '@' . $this->domain; }
} // end class EmailAddress