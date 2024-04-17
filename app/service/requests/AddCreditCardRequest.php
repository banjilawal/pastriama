<?php

namespace app\service\requests;

use app\models\concretes\User;
use app\processors\Process;
use app\services\requests\Request;
use DateTime;

class AddCreditCardRequest extends Request {
    private User $user;
    private string $vendor;
    private string $nameOnCard;
    private string $number;
    private string $cvn;
    private DateTime $expirationDate;


    /**
     * @param User $user
     * @param string $vendor
     * @param string $nameOnCard
     * @param string $number
     * @param string $cvn
     * @param int $expirationMonth
     * @param int $expirationYear
     */
    public function __construct (
        User $user,
        string $vendor,
        string $nameOnCard,
        string $number,
        string $cvn,
        int $expirationMonth,
        int $expirationYear
    ) {
        parent::__construct();
        $this->user = $user;
        $this->vendor = $vendor;
        $this->nameOnCard = $nameOnCard;
        $this->number = $number;
        $this->cvn = $cvn;
        $this->expirationDate = DateTime::createFromFormat(
            'Y-m',
            $expirationYear . '-' . $expirationMonth
        );
    }

    public function getUser (): User {
        return $this->user;
    }

    public function getVendor (): string {
        return $this->vendor;
    }

    public function getNameOnCard (): string {
        return $this->nameOnCard;
    }

    public function getNumber (): string {
        return $this->number;
    }

    public function getCvn (): string {
        return $this->cvn;
    }

    public function getExpirationDate (): DateTime {
        return $this->expirationDate;
    }
}