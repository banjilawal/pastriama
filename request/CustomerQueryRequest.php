<?php

namespace request;

class CustomerQueryRequest extends Request {
    private int $customerId;
    private string $firstname;
    private string $lastname;
    private string $birthdate;
    private string $email;
    private string $password;
    private string $phone;
    private string $street;
    private string $city;
    private string $state;
    private string $zipcode;
    
    public function __construct (string $email, string $password) {
        $this->email = $email;
        $this->password = $password;
    }
    
    
    public function getEmail (): string {
        return $this->email;
    }
    
    
    public function getPassword (): string {
        return $this->password;
    }
}