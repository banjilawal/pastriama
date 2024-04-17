<?php

namespace app\processors;

use app\models\concretes\CreditCard;
use app\models\concretes\User;
use app\service\requests\AddCreditCardRequest;
use app\service\requests\AddShippingAddressRequest;
use app\test\EntityGenerator;
use DateTime;
use Exception;

class Process {

    /**
     * @throws Exception
     */
    public static function addCreditCard (AddCreditCardRequest $request): void {
        $card = new CreditCard(
            EntityGenerator::id(),
            $request->getVendor(),
            $request->getNameOnCard(),
            $request->getNumber(),
            $request->getExpirationDate(),
            $request->getCvn()
        );
        $request->getUser()->getCreditCards()->add($card);
        // Add code to update table
    }

    /**
     * @throws Exception
     */
    public static function addShippingAddress (AddShippingAddressRequest $request): void {
        $address = $request->getAddress();
        $request->getUser()->getShippingAddresses()->add($request->getAddress());
        // Add code to update table
    }
}