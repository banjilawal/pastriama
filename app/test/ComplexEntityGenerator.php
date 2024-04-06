<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\CreditCard;
use app\models\concretes\Invoice;
use app\models\concretes\InvoiceItem;
use app\models\concretes\Pastry;
use app\models\concretes\User;
use app\models\lists\PastryList;
use DateTime;
use Exception;

class ComplexEntityGenerator {
    private const MIN_ADDITIONAL_CARDS = 0;
    private const MAX_ADDITIONAL_CARDS = 5;

    private const MINIMUM_NUMBER_OF_ITEMS = 1;
    private const MAXIMUM_NUMBER_OF_ITEMS = 24;

    private static function getRandomCard (User $user): CreditCard {
        $index = array_rand($user->getCreditCards()->getItems());
        return $user->getCreditCards()->getItems()[$index];
    }

    private static function getRandomItem (PastryList $inventory): Pastry {
        return $inventory->getItems()[array_rand($inventory->getItems())];
    }


    /**
     * @throws Exception
     */
    public static function createUser () : User {
        $firstname = EntityGenerator::firstname();
        $lastname = EntityGenerator::lastname();
        $birthdate = EntityGenerator::someDateTime(
            DateTime::createFromFormat('Y-m-d', '1940-01-01'),
            DateTime::createFromFormat('Y-m-d', '2006-01-01'),
        );
        $phone = EntityGenerator::phone();
        $email = EntityGenerator::email($firstname, $lastname);
        $postalAddress = EntityGenerator::postalAddress();
        $creditCard = EntityGenerator::creditCard(EntityGenerator::id());
        $password = EntityGenerator::password();
        $user = new User(
            EntityGenerator::id(),
            $firstname,
            $lastname,
            $birthdate,
            $phone,
            $email,
            $password,
            $postalAddress,
            $creditCard
        );
        $totalCards = 1 + rand(self::MIN_ADDITIONAL_CARDS, self::MAX_ADDITIONAL_CARDS);
        $counter = 1;
        while ($counter < $totalCards) {
            $creditCard = EntityGenerator::creditCard(EntityGenerator::id());
            $user->getCreditCards()->add($creditCard);
            $counter++;
        }
        return $user;
    }

    public static function createInvoice (int $invoiceId, User $user, PastryList $inventory, int $invoiceSize): Invoice {
        $invoice = new Invoice($invoiceId, $user, self::getRandomCard($user));
        for ($i = 0; $i < $invoiceSize; $i++) {
            $invoice->getItems()->addItem(
                new InvoiceItem(
                    self::getRandomItem($inventory),
                    rand(self::MINIMUM_NUMBER_OF_ITEMS, self::MAXIMUM_NUMBER_OF_ITEMS)
            ));
        }
        return $invoice;
    }
}