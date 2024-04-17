<?php declare(strict_types=1);
namespace app\models\lists;


use app\models\abstracts\Model;
use app\models\concretes\CreditCard;
use app\models\concretes\Order;
use app\models\concretes\Pastry;
use app\models\concretes\User;
use DateTime;
use Exception;

class Orders extends Model {
    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): Order|array {
        return $this->items;
    }

    /**
     * @throws Exception
     */
    public function addOrders (Orders $orders): void {
        foreach ($orders as $order) {
            $this->addOrder($$order);
        }
    }

    /**
     * @throws Exception
     */
    public function addOrder (Order $order): void {
        if (array_key_exists($order->getId(), $this->items)) {
            throw new Exception($order->getId() . ' is already in the list');
        }
        $this->items[$order->getId()] = $order;
    }

    /**
     * @throws Exception
     */
    public function removeOrders (Orders $order): void {
        foreach ($this->items as $id => $order) {
            $this->remove($order);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (Order $order): void {
        $id = $order->getId();
        if (!array_key_exists($id, $this->items)) {
            throw new Exception($id . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->items[$id]);
    }

    /**
     * @throws Exception
     */
    public function filterByPastry (Pastry $pastry): Orders {
        $matches = new Orders();
        foreach ($this->items as $order) {
            if (!is_null($order->search($pastry)))
                $matches->addOrder($order);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByUser (User $user): Orders {
        $matches = new Orders();
        foreach ($this->items as $order) {
            if ($order->getUser()->equals($user))
                $matches->addOrder($order);
        }
        return $matches;
    } // close search

    /**
     * @throws Exception
     */
    public function filterByDateRange (DateTime $startDate, DateTime $endDate): Orders {
        $matches = new Orders();
        foreach ($this->items as $order) {
            if ($order->getSubmitTime() >= $startDate && $order->getSubbmitTime() <= $endDate)
                $matches->addOrder($order);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByCreditCard (CreditCard $creditCard): Orders {
        $matches = new Orders();
        foreach ($this->items as $order) {
            if ($creditCard->equals($order->getCreditCard()))
                $matches->addOrder($order);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function search (User $user, Pastry $pastry, DateTime $startDate, DateTime $endDate): Orders {
        return (($this->filterByDateRange($startDate, $endDate))->filterByPastry($pastry))->filterByUser($user);
    }

    public function __toString  (): string {
        $string =  'Orders:' . PHP_EOL;
        foreach ($this->items as $order) {
            $string  .= $order . PHP_EOL;
        }
        return nl2br($string);
    }

    public function toTable (): string {
        $elem = '<table id="ordersTable">'
            . '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Customer</th>'
            . '<th>Submission Date</th>'
            . '<th>Delivery</th>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $order) {
            $elem .= '<tr>' . $order->toTable() . '</tr>';
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}