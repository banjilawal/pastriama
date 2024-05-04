<?php

namespace app\interfaces\strategies;

interface PaymentStrategy {
    public function pay(float $amount): void;
}

class PaymentContext {
    private $strategy;

    public function __construct(PaymentStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function setStrategy(PaymentStrategy $strategy): void {
        $this->strategy = $strategy;
    }

    public function pay(float $amount): void {
        $this->strategy->pay($amount);
    }
}

// Example usage
$paymentContext = new PaymentContext(new CreditCardPayment("1234-5678-9012-3456", "John Doe"));
$paymentContext->pay(100.0); // Paid 100.0 using Credit Card

// Change strategy to PayPal
$paymentContext->setStrategy(new PayPalPayment("john@example.com"));
$paymentContext->pay(200.0); // Paid 200.0 using PayPal

// Change strategy to Bitcoin
$paymentContext->setStrategy(new BitcoinPayment());
$paymentContext->pay(300.0); // Paid 300.0 using Bitcoin