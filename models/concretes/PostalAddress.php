<?php declare(strict_types=1);
namespace models\concretes;

use model\abstract\Address;

require_once('bootstrap.php');
require_once('Orientation.php');
//   require_once('EntityException.php');

class PostalAddress extends Address {
    private String $streetNumber;
    private Road $road;
    private String $city;
    private State $state;
    private Zipcode $zipcode;
    
    public function __constructor (
        String $streetNumber,
        Road $road,
        String $city, State $state,
        Zipcode $zipcode
    ): void {
        echo 'received street ' . $streetNumber;
        $this->streetNumber = $streetNumber;
        echo 'set  street <- ' . $this->streetNumber . '<br';
        $this->road = $road;
        echo 'received city ' . $city . '<br>';
        $this->city = $city;
        echo 'received state ' .$state . '<br>';
        $this->state = $state;
        $this->zipcode = $zipcode;
    } // close constructor

    //public function get_roadCategory () { return $this->roadCategory; }
    //public function get_orientation () { return $this->orientation; }
    public function get_zipcode (): Zipcode { return $this->zipcode; }
    public function get_street_number (): string { return $this->streetNumber; }
    public function get_state (): State { return $this->state; }
    public function get_road (): Road { return $this->road; }
    public function get_city (): string { return $this->city; }

    public function set_streetNumber (String $streetNumber): void { $this->streetNumber = $streetNumber; }
    public function set_zipCode (ZipCode $zipCode): void { $this->zipcode = $zipCode; }
    public function set_road (Road $road): void { $this->road = $road; }
    public function set_state (State $state): void { $this->state = $state; }
    public function set_city (String $city): void { $this->city = $city; }

    public function __toString (): string {
        if (is_null($this)) {
            return '';
        } return $this->streetNumber
            . ' ' . $this->road
            . ' ' .$this->$this->city
            . ', ' . $this->state
            . ' ' . $this->zipcode;
    } // close toString

    public function to_row () {
        $elem = '<tr class="postal-address-row">'
                . '<td class="field-name">number</td>'
                . '<td>' . $this->streetNumber . '</td>'
                . '<td class=field-name">road</td>'
                . '<td>' . $this->road . '</td>'
                . '<td class=field-name">city</td>'
                . '<td>' . $this->city . '</td>'
                . '<td class="field-name">state</td>'
                . '<td>' . $this->state . '</td>'
                . '<td class="field-name">zip-code</td>'
                . '<td>' . $this->zipcode . '</td>'
            . '</tr>';
        return $elem;
    } // close to_row

    public function to_table () {
        $elem = '<table class="address-table">'
            . '<thead class="address-table-head>'
                . '<tr class="address-table-header-row">'
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
                    . '<td>' . $this->road . '</td>'
                    . '<td>' . $this->city . '</td>'
                    . '<td>' . $this->state . '</td>'
                    . '<td>' . $this->zipcode . '</td>'
                . '</tr>'
            . '</tbody>'
        . '</table>';
        return $elem;
    } // close function to_table
} // end class PostalAddress
?>