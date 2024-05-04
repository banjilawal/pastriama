<?php declare(strict_types=1);

namespace app\strategies\payment;

use app\interfaces\strategies\PaymentStrategy;
use app\models\concretes\CreditCard;


class CreditCardPayment implements PaymentStrategy {
    private CreditCard $card;

    public function __construct(CreditCard $card) {
        $this->card = $card;
    }

    public function pay(float $amount): void {
        echo 'Paid ' .  $amount . ' using Credit Card ' . $this->card; ;
    }
}