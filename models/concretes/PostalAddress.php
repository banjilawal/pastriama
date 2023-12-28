<?php declare(strict_types=1);
namespace models\concretes;


use models\abstracts\Address;

class PostalAddress extends Address {
    private string $street;
    private string $city;
    private State $state;
    private Zipcode $zipcode;
    
    
    public function __construct (
        string $street,
        string $city,
        State $state,
        Zipcode $zipcode
    ) {
        parent::__construct();
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
    }
    
    
    public function getStreet (): string {
        return $this->street;
    }
    
    
    public function getCity (): string {
        return $this->city;
    }
    
    
    public function getState (): State {
        return $this->state;
    }
    
    
    public function getZipcode (): Zipcode {
        return $this->zipcode;
    }
    
    
    public function setStreet (string $street): void {
        $this->street = $street;
    }
    
    
    public function setCity (string $city): void {
        $this->city = $city;
    }
    
    
    public function setState (State $state): void {
        $this->state = $state;
    }
    
    
    public function setZipcode (ZipCode $zipcode): void {
        $this->zipcode = $zipcode;
    }

    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof PostalAddress) {
            return $this->street === $object->getStreet()
                && $this->city === $object->getCity()
                && $this->state->equals($object->getState())
                && $this->zipcode->equals($object->getZipcode());
        }
        return false;
    }

    
    public function __toString (): string {
        return $this->street . ' ' . $this->city . ', ' . $this->state . ' ' . $this->zipcode;
    }
    

    public function toRow (): string {
        return '<tr class="postal-address-row">'
                . '<td class="field-name">number</td>'
                . '<td>' . $this->street . '</td>'
                . '<td class=field-name">city</td>'
                . '<td>' . $this->city . '</td>'
                . '<td class="field-name">state</td>'
                . '<td>' . $this->state . '</td>'
                . '<td class="field-name">zipcode</td>'
                . '<td>' . $this->zipcode . '</td>'
            . '</tr>';
    }
    

    public function toTable (): string {
        return '<table class="postal-address-table" id="postal-address-table" name="postal-address-table">'
            . '<thead>'
                . '<tr>'
                    .   '<th>Street</th>'
                    .   '<th>City</th>'
                    .   '<th>State</th>'
                    .   '<th>Zip</th>'
                .   '</tr>'
            . '</thead>'
            . '<tbody>'
                . '<tr>'
                    . '<td>' . $this->street . '</td>'
                    . '<td>' . $this->city . '</td>'
                    . '<td>' . $this->state . '</td>'
                    . '<td>' . $this->zipcode . '</td>'
                . '</tr>'
            . '</tbody>'
        . '</table>';
    }
} // end class PostalAddress