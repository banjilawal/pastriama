<?php declare(strict_types=1);
namespace app\models\collections;


use app\models\abstracts\Model;
use app\models\concretes\CreditCard;
use app\models\concretes\NewOrder;
use app\models\concretes\Pastry;
use app\models\concretes\User;
use DateTime;
use Exception;

class Orders extends Model {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): NewOrder|array {
        return $this->list;
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
    public function addOrder (NewOrder $order): void {
        if (array_key_exists($order->getId(), $this->list)) {
            throw new Exception($order->getId() . ' is already in the list');
        }
        $this->list[$order->getId()] = $order;
    }

    /**
     * @throws Exception
     */
    public function removeOrders (Orders $order): void {
        foreach ($this->list as $id => $order) {
            $this->remove($order);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (NewOrder $order): void {
        $id = $order->getId();
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($id . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->list[$id]);
    }

    /**
     * @throws Exception
     */
    public function filterByPastry (Pastry $pastry): Orders {
        $matches = new Orders();
        foreach ($this->list as $order) {
            if (!is_null($order->getInvoice()->searchByPastry($pastry)))
                $matches->addOrder($order);
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
                $matches->addOrder($order);
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
                $matches->addOrder($order);
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
                $matches->addOrder($order);
        }
        return $matches;
    }

    public function contains (NewOrder $order): bool {
        return array_key_exists($order->getid(), $this->list);
    }

    public function __toString  (): string {
        $string =  'Orders:' . PHP_EOL;
        foreach ($this->list as $order) {
            $string  .= $order . PHP_EOL;
        }
        return nl2br($string);
    }

    public function tableHeader (): string {
        return '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Customer</th>'
            . '<th>Delivery Address</th>'
            . '<th>Submission Date</th>'
            . '<th>Delivery Date</th>'
            . ' <th>Total</th>'
            . '</thead>';
    }

    public function tableBody (): string {
        $elem = '<tbody>';
        foreach ($this->list as $id => $order) {
            $elem .= '<tr id="orderId_' . $id . '" onclick="rowClickHandler(' . $id . ')">'
                . '<td>' . $id . '</td>'
                . '<td>' . $order->getUser()->printName() . '</td>'
                . '<td>' . $order->getRecipientName() . ' ' . $order->getShippingAddress() . '</td>'
                . '<td>' . $order->submissionTime->format(DATE_TIME_FORMAT) . '</td>'
                . '<td>' . $order->printDeliveryDate() . '</td>'
                . '<td>' . number_format($order->getTotalCharge(), 2) . '</td></tr>';
        }
        $elem .= '</tbody>';
        return $elem;
    }

    public function toTable (): string {
        return '<table id="ordersTable">' . $this->tableHeader() . $this->tableBody() . '</table>';
    }

    public function randomOrder (): NewOrder { return $this->list[array_rand($this->list)]; }
}