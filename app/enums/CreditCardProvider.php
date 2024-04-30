<?php declare(strict_types=1);

namespace app\enums;

use app\models\concretes\CreditCard;

enum CreditCardProvider: string {

    case VISA = 'Visa';
    case DISCOVER = 'Discover';
    case MASTERCARD = 'Mastercard';
    case AMEX = 'American Express';

    public static function selector (): string {
        $elem = '<label for="cardProvider">Credit Card Provider</label>'
            . '<select id="cardProvider" name="cardProvider" required>';
        foreach (CreditCardProvider::cases() as $cardProvider) {
            $elem .= '<option value"' . $cardProvider->value . '">' . $cardProvider->name . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }

    public function number (): int {
        return match($this) {
            CreditCardProvider::VISA => 0,
            CreditCardProvider::DISCOVER => 1,
            CreditCardProvider::MASTERCARD => 2,
            CreditCardProvider::AMEX => 4,
        };
    }

    public static function fromNumber (int $number): CreditCardProvider {
        return match($number) {
            0 => CreditCardProvider::VISA,
            1 => CreditCardProvider::DISCOVER,
            2 => CreditCardProvider::MASTERCARD,
            3 => CreditCardProvider::AMEX,
        };
    }

    public static function random (): CreditCardProvider {
        return CreditCardProvider::fromNumber(rand(0, 3));
    }
}