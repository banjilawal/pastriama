<?php

namespace app\processors;

use app\models\concretes\CreditCard;
use app\services\requests\requests\AddCreditCardRequest;
use app\services\requests\requests\AddShippingAddressRequest;
use app\test\NewEntityGenerator;
use Exception;

class Process {

    /**
     * @throws Exception
     */
    public static function addCreditCard (AddCreditCardRequest $request): void {
        $card = new CreditCard(
            NewEntityGenerator::id(),
            $request->getVendor(),
            $request->getNameOnCard(),
            $request->getNumber(),
            $request->getExpirationDate(),
            $request->getCvn()
        );
        $request->getUser()->getCreditCards()->addCard($card);
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