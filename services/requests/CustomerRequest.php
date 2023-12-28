<?php

namespace services\request;

class CustomerRequest extends Request {
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private string $phone;
    private string $street;
    private string $city;
    private string $state;
    private string $zipcode;
    
    
    
//    public function __construct (string $firstname, string $lastname, string $email, string $password, string $phone, string $street, string $state, string $zipcode) {
//        $this->email = $email;
//        $this->password = $password;
//    }
//
    /**
     * @param int $id
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param string $phone
     * @param string $street
     * @param string $city
     * @param string $state
     * @param string $zipcode
     */
    public function __construct (
        int $id, string $firstname, string $lastname, string $email, string $password,
        string $phone, string $street, string $city, string $state, string $zipcode
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
    }
    
    public function getId (): int {
        return $this->id;
    }
    
    public function getFirstname (): string {
        return $this->firstname;
    }
    
    public function getLastname (): string {
        return $this->lastname;
    }

    
    public function getEmail (): string {
        return $this->email;
    }
    
    public function getPassword (): string {
        return $this->password;
    }
    
    public function getPhone (): string {
        return $this->phone;
    }
    
    public function getStreet (): string {
        return $this->street;
    }
    
    public function getCity (): string {
        return $this->city;
    }
    
    public function getState (): string {
        return $this->state;
    }
    
    public function getZipcode (): string {
        return $this->zipcode;
    }
    
    
    
    
//    public function getEmail (): string {
//        return $this->email;
//    }
//
//
//    public function getPassword (): string {
//        return $this->password;
//    }
}