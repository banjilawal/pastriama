<?php

namespace app\models\concretes;

use app\models\abstracts\Transaction;
use DateTime;

class ReturnTransaction extends Transaction {
    private int $creditCardId;
    private int $orderId;
    private int $itemId;
    private int $quantity;
    private float $amount;
    private DateTime $dateReceived;

    /**
     * @param int $creditCardId
     * @param int $orderId
     * @param int $itemId
     * @param int $quantity
     * @param float $amount
     * @param DateTime $dateReceived
     */
    public function __construct (
        int $creditCardId,
        int $orderId,
        int $itemId,
        int $quantity,
        float $amount,
        DateTime $dateReceived
    ) {
        parent::__construct();
        $this->creditCardId = $creditCardId;
        $this->orderId = $orderId;
        $this->itemId = $itemId;
        $this->quantity = $quantity;
        $this->amount = $amount;
        $this->dateReceived = $dateReceived;
    }

    public function getCreditCardId (): int {
        return $this->creditCardId;
    }

    public function getOrderId (): int {
        return $this->orderId;
    }

    public function getItemId (): int {
        return $this->itemId;
    }

    public function getQuantity (): int {
        return $this->quantity;
    }

    public function getAmount (): float {
        return $this->amount;
    }

    public function getDateReceived (): DateTime {
        return $this->dateReceived;
    }
}