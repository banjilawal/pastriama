<?php

namespace app\service\requests;

use app\enums\CreditCardProvider;
use app\models\concretes\CreditCard;
use app\models\concretes\User;
use app\services\requests\Request;
use app\utils\SerialNumber;
use DateTime;
use Exception;

class AddCreditCardRequest extends Request {
    private User $user;
    private CreditCard $creditCard;


    /**
     * @param User $user
     * @param string $cardProvider
     * @param string $nameOnCard
     * @param string $number
     * @param string $cvn
     * @param int $expirationMonth
     * @param int $expirationYear
     * @throws Exception
     */
    public function __construct (
        User $user,
        string $cardProvider,
        string $nameOnCard,
        string $number,
        string $cvn,
        int $expirationMonth,
        int $expirationYear
    ) {
        parent::__construct();
        $this->user = $user;
        $this->creditCard = new CreditCard(
            SerialNumber::nextCreditCardId(),
            CreditCardProvider::from(sanitize_input($cardProvider)),
            sanitize_input($nameOnCard),
            sanitize_input($number),
            DateTime::createFromFormat('Y/m', $expirationYear . '/' . $expirationMonth),
            sanitize_input($cvn)
        );
    }

    public function getUser (): User {
        return $this->user;
    }

    public function getCreditCard (): CreditCard {
        return $this->creditCard;
    }
}