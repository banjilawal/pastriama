<?php declare(strict_types=1);

namespace app\models\concretes;

use app\utils\Util;
use DateTime;

class Receipt {
    private int $orderId;
    private string $creditCard;
    private DateTime $timestamp;
    private DateTime $deliveryDate;
    private array $orderItems;

    public function __construct (Order $order) {
        $this->orderId = $order->getId();
        $this->creditCard = $order->getCreditCard()->__toString();
        $this->timestamp = $order->getTimestamp();
        $this->deliveryDate = $order->getDeliveryDate();
        $this->orderItems = array();
        foreach($order->getItems() as $id => $item) {
            $hash = [
                'itemId' => $item->getId(),
                'name' => $item->getProduct()->getName(),
                'quantity' => $item->getQuantity()
            ];
            $this->orderItems[] = $hash;
        }
    }

    public function getOrderId (): int {
        return $this->orderId;
    }

    public function getCreditCard (): string {
        return $this->creditCard;
    }

    public function getTimestamp (): DateTime {
        return $this->timestamp;
    }

    public function getOrderItems (): array {
        return $this->orderItems;
    }

    public function __toString (): string {
        $string = '$orderId:' . $this->orderId . ' credit card:' . $this->creditCard
            . Util::deliveryDateHandler($this->deliveryDate) . PHP_EOL;
        foreach ($this->orderItems as $orderItem) {
            $string .= $orderItem['id'] . ':' . $orderItem['name'] . ' quantity:' . $orderItem['quantity'] . PHP_EOL;
        }
        return $string;
    }

}