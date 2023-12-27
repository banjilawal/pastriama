<?php declare(strict_types=1);
namespace models\concretes;

use model\abstract\Address;

require_once('bootstrap.php');
require_once('Orientation.php');
//   require_once('EntityException.php');

class PostalAddress extends Address {
    private string $streetNumber;
//    private Road $road;
    private string $city;
    private State $state;
    private Zipcode $zipcode;
    
    
    public function __construct (
        string $street_number,
//        Road $road,
        string $city,
        State $state,
        Zipcode $zipcode
    ) {
        parent::__construct();
        $this->streetNumber = $street_number;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
    }
    
    
    public function getZipcode (): Zipcode {
        return $this->zipcode;
    }
    
    
    public function getStreetNumber (): string {
        return $this->streetNumber;
    }
    
    
    public function getState (): State {
        return $this->state;
    }
    
    
//    public function getRoad (): Road {
//        return $this->road;
//    }
    
    
    public function getCity (): string {
        return $this->city;
    }

    
    public function setStreetNumber (string $streetNumber): void {
        $this->streetNumber = $streetNumber;
    }
    
    
    public function setZipcode (ZipCode $zipcode): void {
        $this->zipcode = $zipcode;
    }
    
    
//    public function setRoad (Road $road): void {
//        $this->road = $road;
//    }
    
    
    public function setState (State $state): void {
        $this->state = $state;
    }
    
    
    public function setCity (string $city): void {
        $this->city = $city;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof PostalAddress) {
            return $this->streetNumber === $object->getStreetNumber()
                && $this->zipcode->equals($object->getZipcode())
                && $this->state->equals($object->getState())
                && $this->city === $object->getCity();
//                && $this->road->equals($object->getRoad());
        }
        return false;
    }

    
    public function __toString (): string {
        if (is_null($this)) {
            return '';
        } return $this->streetNumber
//            . ' ' . $this->road
            . ' ' .$this->$this->city
            . ', ' . $this->state
            . ' ' . $this->zipcode;
    }
    

    public function toRow (): string {
        return '<tr class="postal-address-row">'
                . '<td class="field-name">number</td>'
                . '<td>' . $this->streetNumber . '</td>'
//                . '<td class=field-name">road</td>'
//                . '<td>' . $this->road . '</td>'
                . '<td class=field-name">city</td>'
                . '<td>' . $this->city . '</td>'
                . '<td class="field-name">state</td>'
                . '<td>' . $this->state . '</td>'
                . '<td class="field-name">zipcode</td>'
                . '<td>' . $this->zipcode . '</td>'
            . '</tr>';
    }
    

    public function toTable (): string {
        return '<table class="address-table">'
            . '<thead class="address-table-head>'
                . '<tr>'
                    .   '<th>Street</th>'
                    .   '<th>Road</th>'
                    .   '<th>City</th>'
                    .   '<th>State</th>'
                    .   '<th>Zip</th>'
                .   '</tr>'
            . '</thead>'
            . '<tbody>'
                . '<tr>'
                    . '<td>' . $this->streetNumber . '</td>'
//                    . '<td>' . $this->road . '</td>'
                    . '<td>' . $this->city . '</td>'
                    . '<td>' . $this->state . '</td>'
                    . '<td>' . $this->zipcode . '</td>'
                . '</tr>'
            . '</tbody>'
        . '</table>';
    }
} // end class PostalAddress