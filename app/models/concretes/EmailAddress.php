<?php declare(strict_types=1);

namespace app\models\concretes;


use app\models\abstracts\Address;

class EmailAddress extends Address {
    private string $mailbox;
    private Domain $domain;

    /**
     * @param string $mailbox
     * @param Domain $domain
     */
    public function __construct (string $mailbox, Domain $domain) {
        parent::__construct();
        $this->mailbox = trim($mailbox, ' ');
        $this->domain = $domain;
    }

    public function getMailbox (): string {
        return $this->mailbox;
    }

    public function getDomain (): Domain {
        return $this->domain;
    }

    public function setMailbox (string $mailbox): void {
        $this->mailbox = $mailbox;
    }

    public function setDomain (Domain $domain): void {
        $this->domain = $domain;
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
        return $this->mailbox . trim('@') . $this->domain;
    }
}