<?php
namespace model\abstract;

use DateTime;
use Exception;
use models\concretes\CreditCard;
use models\concretes\Customer;
use models\concretes\InvoiceItem;
use models\concretes\Pastry;
use models\concretes\WishListItem;
use models\enums\OrderStatus;

class WishList extends Entity {

    private Customer $customer;
    private array $wishList;
    

    public function __construct (int $id, Customer $customer) {
        parent::__construct($id);
        $this->customer = $customer;
        $this->wishList = array();
    }
    

    public function getCustomer (): Customer {
        return $this->customer;
    }


    public function getWishList (): array {
        return $this->wishList;
    }
    
    
    public function __toString (): string {
        $string = '';
        foreach ($this->wishList as $item) {
            $string .= nl2br($item);
        }
        return $string;
    }
    
    
    /**
     * @throws Exception
     */
    public function add (WishListItem $wishListItem): void {
        $id = $wishListItem->getPastry()->getId();
        if (array_key_exists($id, $this->wishList)) {
            throw new Exception($wishListItem->getPastry()->getName() . '  is already in your wish list.');
        }
        $this->wishList[$id] = $wishListItem;
    }
    
    
    /**
     * @throws Exception
     */
    public function remove (WishListItem $wishListItem): void {
        $id = $wishListItem->getPastry()->getId();
        if (!array_key_exists($id, $this->wishList)) {
            throw new Exception($wishListItem->getPastry()->getName() . '  does not exist in your wish list it cannot be removed.');
        }
        unset($this->wishList[$id]);
    }
    
    
    public function toTable (): string {
        $tableName = 'wishList-' . $this->getId() . '-table';
        $elem = '<table class="' . 'wishList-table' . '" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th></th>'
            . '<th>Date Added</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->wishList as $item) {
            $elem .= $item->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
} // end class WishList