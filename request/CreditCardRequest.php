<?php

namespace request;

use global\Validate;

class CreditCardRequest {
    private string $ownerFirstname;
    private string $ownerLastname;
    private string $number;
    private \DateTime $expiration;
    private string $cvn;
    
    
    /**
     * @param string $ownerFirstname
     * @param string $ownerLastname
     * @param string $number
     * @param \DateTime $expiration
     * @param string $cvn
     */
    public function __construct (
        string $ownerFirstname, string $ownerLastname,
        string $number, \DateTime $expiration, string $cvn
    ) {
        $this->ownerFirstname = $ownerFirstname;
        $this->ownerLastname = $ownerLastname;
        $this->number = $number;
        $this->expiration = $expiration;
        $this->cvn = $cvn;
    }
    
    
    public function getOwnerFirstname (): string {
        return $this->ownerFirstname;
    }
    
    
    public function getOwnerLastname (): string {
        return $this->ownerLastname;
    }
    
    
    public function getNumber (): string {
        return $this->number;
    }
    
    
    public function getExpiration (): \DateTime {
        return $this->expiration;
    }
    
    
    public function getCvn (): string {
        return $this->cvn;
    }
}