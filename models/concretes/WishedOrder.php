<?php
namespace model\abstract;

use DateTime;
use models\concretes\CreditCard;
use models\concretes\OrderItem;
use models\enums\OrderStatus;

class WishedOrder extends Order {

    public function __construct (int $id, Customer $customer) {
        parent::__construct($id, $customer);
    }
    
    public function equals ($object): boolean {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof WishedOrder)
            return parent::equals($object);
        return false;
    }
} // end class Order