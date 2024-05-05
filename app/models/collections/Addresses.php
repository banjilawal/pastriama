<?php declare(strict_types=1);

namespace app\models\collections;

use app\enums\State;
use app\models\abstracts\Aggregation;
use app\models\abstracts\Model;
use app\models\concretes\InventoryItem;
use app\models\concretes\PostalAddress;
use app\models\concretes\Zipcode;
use Exception;

class Addresses extends Aggregation {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): PostalAddress|array {
        return $this->list;
    }

//    /**
//     * @throws Exception
//     */
//    public function getPrimaryShippingAddress (): PostalAddress {
//        foreach ($this->list as $postalAddress) {
//            if ($postalAddress->getMailingCategory() !== MailingCategory::PRIMARY_PACKAGE_DELIVERY_CHOICE)
//                return $postalAddress;
//        }
//        return
//    }


//    public function setPrimaryShippingAddress (PostalAddress $address): void {
//        $index = $this->getIndex($address);
//        if ($index === PHP_INT_MIN) {
//            $this->list[] = $address;
//            $index = count($this->list) - 1;
//        }
//        $this->switchAddresses(self::$PRIMARY_SHIPPING_ADDRESS_INDEX, $index);
//    }

//    /**
//     * @throws Exception
//     */
//    public function setBillingAddressIndex (int $index): void {
//        if ($index < 0 || $index > count($this->items) - 1) {
//            throw new Exception ($index . ' is outside the postal address array index out of bounds');
//        }
//        $this->billingAddressIndex = $index;
//    }

//    /**
//     * @throws Exception
//     */
//    public function setPrimaryShippingAddressIndex (int $index): void {
//        if ($index < 0 || $index > count($this->items) - 1) {
//            throw new Exception ($index . ' is outside the postal address array index out of bounds');
//        }
//        $this->primaryShippingAddressIndex = $index;
//    }

    /**
     * @throws Exception
     */
    public function add (PostalAddress $address): void {
        if (array_key_exists($address->getId(), $this->list)) {
            throw new Exception($address . ' is already in the list');
        }
        $this->list[$address->getId()] = $address;
    }


    /**
     * @throws Exception
     */
    public function remove (PostalAddress $address): void {
//        if (count($this->list) <= 0) {
//            throw new Exception('Cannot remove the only address in the list.');
//        }
        if (!array_key_exists($address->getId(), $this->list)) {
            throw new Exception($address . ' is not in the list. Cannot remove nonexistent postal address');
        }
        unset($this->list[$address->getId()]);
    }

    public function searchById (int $id): ?PostalAddress {
        if (array_key_exists($id, $this->list)) {
            return $this->list[$id];
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function filterByCity (string $city): Addresses {
        $matches = new Addresses();
        foreach ($this->list as $id => $address) {
            if ($address->getCity() === $city) {
                $matches->add($address);
            }
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByState (State $state): Addresses {
        $matches = new Addresses();
        foreach ($this->list as $id => $address) {
            if ($address->getState() === $state) {
                $matches->add($address);
            }
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByZipcode (Zipcode $zipcode): Addresses {
        $matches = new Addresses();
        foreach ($this->list as $id => $address) {
            if ($address->getState() === $zipcode) {
                $matches->add($address);
            }
        }
        return $matches;
    }

    public function __toString  (): string {
        $string = 'Postal Addresses:' . PHP_EOL;
        foreach ($this->list as $address) {
            $string  .=  $address . PHP_EOL;
        }
        return $string;
    }

    public function tableHeader (): string {
        return '<table id="postalAddressListTable">'
            . '<thead>'
            . '<tr>'
            . '<th>ID</th>'
//            .   '<th>Primary</th>'
            .   '<th>Address</th>'
//            .   '<th>Remove</th>'
            .   '<th>City</th>'
            .   '<th>State</th>'
            .   '<th>Zip</th>'
            .   '</tr>'
            . '</thead>';
    }

    public function tableBody (): string {
        $elem = '<tbody>';
        foreach ($this->list as $id => $address) {
            $elem .= '<tr>'
                . '<td>' . $address->getId() .  '</td>'
                . '<td>' . $address->getStreet() .  '</td>'
                . '<td>' . $address->getCity() . '</td>'
                . '<td>' . $address->getState()->name . '</td>'
                . '<td>' . $address->getZipcode() . '</td>'
                . '</tr>';
        }
        $elem .= '</tbody>';
        return $elem;
    }

    public function toTable (): string {
        return $this->tableHeader() . $this->tableBody();
    }


//    public function toTable (): string {
//        $elem = '<table id="postalAddressListTable">'
//            . '<thead>'
//            . '<tr>'
//            .   '<th>Primary</th>'
//            .   '<th>Address</th>'
//            .   '<th>Remove</th>'
//            .   '<th>City</th>'
//            .   '<th>State</th>'
//            .   '<th>Zip</th>'
//            .   '</tr>'
//            . '</thead>'
//            . '<tbody>'
//            . '<tr>'
//            .   '<td></td>'
////            .   '<td><label for="blankRadio"></label><input type="radio" id="blankRadio"></td>'
//            .   '<td>' . $this->list[0] . '</td>'
//            .   '<td>'
//            .       '<button type="button" id="removeButton1" onclick="removeAddress("'. 0 . '")>Remove</button>'
//            .   '</td>'
//            . '</tr>';
//        for ($i = 1; $i < count($this->list); $i++) {
//            $radioName = 'primaryMailingAddress' . $i;
//            $buttonName = 'removeAddress' . $i;
//            $radioLabel = '<label for="' . $radioName . '"></label>';
//            $elem .= '<tr>'
//                . '<td>' . $radioLabel . '<input type="radio" id="' . $radioName . '" value="' . $i . '"></td>'
//                . '<td>' . $this->list[$i] . '</td>'
//                . '<td><button type="button" id="'. $buttonName . '" onclick="removeAddress("'. $i . '")>Remove</button></td>'
//                . '</tr>';
//        }
//        $elem .= '<tbody></table>';
//        return $elem;
//    }
//
//    public function selector (): string {
//        $elem = '<label for ="shipTo"">Ship To</label><select id="shipTo" name="shipTo">'
//            . '<option value="' . $this->list[self::$PRIMARY_SHIPPING_ADDRESS_INDEX] . '" selected>'
//            . $this->list[self::$PRIMARY_SHIPPING_ADDRESS_INDEX] . '</option>';
//        for ($i = 1; $i < count($this->list); $i++) {
//            $elem .= '<option value="' . $this->list[$i] . '">' . $this->list[$i] . '</option>';
//        }
//        $elem .= '</select>';
//        return $elem;
//    }
//
//    public function randomAddress (): PostalAddress {
//        return $this->list[array_rand($this->list)];
//    }
//
//    public function billingAddressSelector (): string {
//        $elem = '<label for ="billingAddress">Billing Address</label>'
//            . '<select id="billingAddress" name="billingAddress" required>';
//        foreach ($this->items as $id => $address) {
//            $elem .= '<option value="' . $id . '">' . $this->items[$id] . '</option>';
//        }
//        $elem .= '</select>';
//        return $elem;
//    }
//
//    public function preferredShippingAddressSelector (): string {
//        $elem = '<label for ="preferredShippingAddress">Preferred Shipping Address</label>'
//            . '<select id="preferredShippingAddress" name="preferredShippingAddress" required>';
//        foreach ($this->items as $id => $address) {
//            $elem .= '<option value="' . $id . '">' . $this->items[$id] . '</option>';
//        }
//        $elem .= '</select>';
//        return $elem;
//    }
//
    public function selector (): string {
        $elem = '<label for ="shipToAddress">Ship to</label>'
            . '<select id="shipToAddress" name="shipToAddress" required>';
        foreach ($this->list as $id => $address) {
            $elem .= '<option value="' . $id . '">' . $this->list[$id] . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }

    public function random (): PostalAddress {
        return $this->list[array_rand($this->list)];
    }
}