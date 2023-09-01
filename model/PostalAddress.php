<?php declare(strict_types=1);

    require_once('bootstrap.php');
    require_once('Address.php');
    require_once('ZipCode.php');
    require_once('State.php');
    require_once('RoadCategory.php');
    require_once('Orientation.php');
 //   require_once('EmptyStringException.php');

    class PostalAddress extends Address {
        private String $streetNumber;
        private String $city;
        private State $state;
        private ZipCode $zipcode; 
        
        public function __constructor (String $streetNumber, String $city, State $state, ZipCode $zipcode) {
            echo 'received street ' . $streetNumber; 
            $this->streetNumber = $streetNumber;
            echo 'set  street <- ' . $this->streetNumber . '<br';

            echo 'received city ' . $city . '<br>';
            $this->city = $city;
            echo 'received state ' .$state . '<br>';
            $this->state = $state;
            $this->zipcode = $zipcode;
        } // close constructor

        //public function get_roadCategory () { return $this->roadCategory; }
        //public function get_orientation () { return $this->orientation; }
        public function get_zipcode () { return $this->zipcode; }
        public function get_street_number () { return $this->streetNumber; }
        public function get_state () { return $this->state; }
        public function get_city () { return $this->city; }

        public function set_streetNumber (String $streetNumber) { $this->streetNumber = $streetNumber; }
        public function set_zipCode (ZipCode $zipCode) { $this->zipCode = $zipCode; }
        public function set_state (State $state) { $this->state = $state; }
        public function set_city (String $city) { $this->city = $city; }

        public function __toString () { 
            if (is_null($this)) {
                return '';
            } return $this->streetNumber . ' ' . $this->$this->city . ', ' . $this->state . ' ' . $this->zipCode;  
        } // close toString

        public function to_row () {
            $elem = '<tr class="postal-address-row">'
                    . '<td class="field-name">number</td>'
                    . '<td>' . $this->streetNumber . '</td>'
                    . '<td class=field-name">city</td>'
                    . '<td>' . $this->city . '</td>'
                    . '<td class="field-name">state</td>'
                    . '<td>' . $this->state . '</td>'
                    . '<td class="field-name">zip-code</td>'
                    . '<td>' . $this->zipCode . '</td>'
                . '</tr>';
            return $elem;     
        } // close to_row

        public function to_table () {
            $elem = '<table class="address-table">'
                . '<thead class="address-table-head>'
                    . '<tr class="address-table-header-row">'
                        .   '<th>Street</th>'
                        .   '<th>City</th>'
                        .   '<th>State</th>'
                        .   '<th>Zip</th>'
                    .   '</tr>'
                . '</thead>'
                . '<tbody>'
                    . '<tr>'
                        . '<td>' . $this->streetNumber . '</td>'
                        . '<td>' . $this->city . '</td>'
                        . '<td>' . $this->state . '</td>'
                        . '<td>' . $this->zipCode . '</td>'
                    . '</tr>'
                . '</tbody>'
            . '</table>';
            return $elem; 
        } // close function to_table
    } // end class PostalAddress
?>