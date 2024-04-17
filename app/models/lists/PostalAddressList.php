<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\CreditCard;
use app\models\concretes\PostalAddress;
use Exception;

class PostalAddressList extends Model {
    public static int $PRIMARY_SHIPPING_ADDRESS_INDEX = 0;
    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): PostalAddress|array {
        return $this->items;
    }

    /**
     * @throws Exception
     */
    public function getPrimaryShippingAddress (): PostalAddress {
        if (count($this->items) == 0) {
            throw new Exception('There are no credit cards. Cannot get nonexistent primary credit card.');
        }
        return $this->items[0];
    }


    public function setPrimaryShippingAddress (PostalAddress $address): void {
        $index = $this->getIndex($address);
        if ($index === PHP_INT_MIN) {
            $this->items[] = $address;
            $index = count($this->items) - 1;
        }
        $this->switchAddresses(self::$PRIMARY_SHIPPING_ADDRESS_INDEX, $index);
    }

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
    public function addAddresses (PostalAddressList $addresses): void {
        foreach ($addresses as $address) {
            $this->add($address);
        }
    }

    /**
     * @throws Exception
     */
    public function add (PostalAddress $postalAddress): void {
        if ($this->getIndex($postalAddress) != PHP_INT_MIN) {
            throw new Exception($postalAddress . ' is already in the list');
        }
        $this->items[] = $postalAddress;
    }

    /**
     * @throws Exception
     */
    public function removeAddresses (PostalAddressList $addresses): void {
        foreach ($addresses as $address) {
            $this->remove($address);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (PostalAddress $postalAddress): void {
        if (count($this->items) <= 0) {
            throw new Exception('Cannot remove the only address in the list.');
        }
        $index = $this->getIndex($postalAddress);
        if ($index === PHP_INT_MIN) {
            throw new Exception($postalAddress
                . ' is not in the list. Cannot remove nonexistent postal address');
        }
        unset($this->items[$index]);
    }

    private function getIndex (PostalAddress $target): int {
        $index = 0;
        foreach ($this->items as $postalAddress) {
            if ($postalAddress->equals($target)) {
                return $index;
            }
            $index++;
        }
        return PHP_INT_MIN;
    }

    private function switchAddresses (int $locationA, int $locationB): void {
        $temp = $this->items[$locationA];
        $this->items[$locationA] = $this->items[$locationB];
        $this->items[$locationB] = $temp;
    }

    public function toString  (): string {
        $string = 'Postal Addresses:' . PHP_EOL;
        foreach ($this->items as $address) {
            $string  .=  $address . PHP_EOL;
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table id="postalAddressListTable">'
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
            . '<tbody>'
            . '<tr>'
            .   '<td></td>'
//            .   '<td><label for="blankRadio"></label><input type="radio" id="blankRadio"></td>'
            .   '<td>' . $this->items[0] . '</td>'
            .   '<td>'
            .       '<button type="button" id="removeButton1" onclick="removeAddress("'. 0 . '")>Remove</button>'
            .   '</td>'
            . '</tr>';
        for ($i = 1; $i < count($this->items); $i++) {
            $radioName = 'primaryMailingAddress' . $i;
            $buttonName = 'removeAddress' . $i;
            $radioLabel = '<label for="' . $radioName . '"></label>';
            $elem .= '<tr>'
                . '<td>' . $radioLabel . '<input type="radio" id="' . $radioName . '" value="' . $i . '"></td>'
                . '<td>' . $this->items[$i] . '</td>'
                . '<td><button type="button" id="'. $buttonName . '" onclick="removeAddress("'. $i . '")>Remove</button></td>'
                . '</tr>';
        }
        $elem .= '<tbody></table>';
        return $elem;
    }

    public function shipToAddressSelector (): string {
        $elem = '<label for ="shipTo"">Ship To</label><select id="shipTo" name="shipTo">'
            . '<option value="' . $this->items[self::$PRIMARY_SHIPPING_ADDRESS_INDEX] . '" selected>'
            . $this->items[self::$PRIMARY_SHIPPING_ADDRESS_INDEX] . '</option>';
        for ($i = 1; $i < count($this->items); $i++) {
            $elem .= '<option value="' . $this->items[$i] . '">' . $this->items[$i] . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
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
//    public function shipToAddressSelector (): string {
//        $elem = '<label for ="shipToAddress">Preferred Shipping Address</label>'
//            . '<select id="shipToAddress" name="shipToAddress" required>';
//        foreach ($this->items as $id => $address) {
//            $elem .= '<option value="' . $id . '">' . $this->items[$id] . '</option>';
//        }
//        $elem .= '</select>';
//        return $elem;
//    }
}