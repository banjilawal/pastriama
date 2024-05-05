<?php declare(strict_types=1);
namespace app\models\collections;

use app\models\abstracts\Aggregation;
use app\models\abstracts\Model;
use app\models\abstracts\Product;
use app\models\concretes\CreditCard;
use app\models\concretes\Order;
use app\models\concretes\User;

use DateTime;
use Exception;

class Orders extends Aggregation {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): Order|array {
        return $this->list;
    }

    /**
     * @throws Exception
     */
    public function add (Order $order): void {
        if (array_key_exists($order->getId(), $this->list)) {
            throw new Exception($order->getId() . ' is already in the list');
        }
        $this->list[$order->getId()] = $order;
    }

    /**
     * @throws Exception
     */
    public function remove (Order $order): void {
        $id = $order->getId();
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($id . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->list[$id]);
    }

    /**
     * @throws Exception
     */
    public function filterByProduct (Product $product): Orders {
        $matches = new Orders();
        foreach ($this->list as $order) {
            if ($order->contains($product))
                $matches->add($order);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByUser (User $user): Orders {
        $matches = new Orders();
        foreach ($this->list as $order) {
            if ($order->getUser()->equals($user))
                $matches->add($order);
        }
        return $matches;
    } // close search

    /**
     * @throws Exception
     */
    public function filterByDateRange (DateTime $startDate, DateTime $endDate): Orders {
        $matches = new Orders();
        foreach ($this->list as $order) {
            if ($order->getSubmitTime() >= $startDate && $order->getSubbmitTime() <= $endDate)
                $matches->add($order);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByCreditCard (CreditCard $creditCard): Orders {
        $matches = new Orders();
        foreach ($this->list as $order) {
            if ($creditCard->equals($order->getCreditCard()))
                $matches->add($order);
        }
        return $matches;
    }

    public function contains (Order $order): bool {
        return array_key_exists($order->getid(), $this->list);
    }

    public function __toString  (): string {
        $string =  'Orders:' . PHP_EOL;
        foreach ($this->list as $order) {
            $string  .= $order . PHP_EOL;
        }
        return$string;
    }

    public function random (): Order { return $this->list[array_rand($this->list)]; }
}