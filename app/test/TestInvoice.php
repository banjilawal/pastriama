<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\CreditCard;
use app\models\concretes\Order;
use app\models\concretes\InvoiceItem;
use app\models\concretes\User;
use app\models\lists\Invoice;
use app\models\lists\Pastries;
use DateTime;
use Exception;

class TestInvoice {
    private const MINIMUM_SIZE = 1;
    private const MAXIMUM_SIZE = 20;
//    private User $user;
//    private int $invoiceSize;
//
//
//    /**
//     * @param User $user
//     */
//    public function __construct (User $user) {
//        $this->user = $user;
//        $this->invoiceSize = rand(self::MAXIMUM_SIZE, self::MAXIMUM_SIZE);
//    }
//
//    public function getRandomCard (): CreditCard {
//        $index = array_rand($this->user->getCreditCards()->getCards());
//        return $this->user->getCreditCards()->getCards()[$index];
//    }
//
//    public function getUser (): User {
//        return $this->user;
//    }
//
//    public function getInvoiceSize (): int {
//        return $this->invoiceSize;
//    }
//
//    /**
//     * @throws Exception
//     */
//    public function getSubmissionDate (): \DateTime {
//        return \app\test\EntityGenerator::someDateTime(
//            DateTime::createFromFormat('Y-m-d', '2022-01-01'),
//            DateTime::createFromFormat('Y-m-d', '2023-03-15')
//        );
//    }
//
//    /**
//     * @throws Exception
//     */
//    public static function createItemList (PastryList $pastries): InvoiceItemList {
//        $items = new InvoiceItemList();
//        foreach ($pastries as $pastry) {
//            $items->addItem(new InvoiceItem($pastry, rand(self::MINIMUM_SIZE, self::MAXIMUM_SIZE)));
//        }
//        return $items;
//    }

//    /**
//     * @throws Exception
//     */
//    public function __toString (): string {
//        return 'Order Submission Date:' . $this->getSubmissionDate()->format('Y-m-d H:i:s')
//            . PHP_EOL . 'Customer:' . $this->user->getFirstname() . ' ' .  $this->user->getLastname()
//            . PHP_EOL . 'Credit Card:' . $this->getRandomCard()
//            . PHP_EOL . 'Order Size:' . $this->invoiceSize;
//    }

//    /**
//     * @throws Exception
//     */
    public static function createInvoice (int $invoiceId, User $user, Pastries $inventory, int $invoiceSize): Order {
        $index = array_rand($user->getCreditCards()->getItems());
        $card = $user->getCreditCards()->getItems()[$index];
        $invoice = new Order($invoiceId, $user, $card);
        $counter = 0;
        while ($counter < $invoiceSize) {
//            $pastry = $inventory->getPastries()[array_rand($inventory->getPastries())];
//            $quantity = rand(self::MINIMUM_SIZE, self::MAXIMUM_SIZE);
            //echo 'invoice size:' . $invoiceSize . ' counter:' . $counter . ' got pastry ' . $pastry->getName() . ' quantity ' . $quantity . '<br>' . PHP_EOL;
            //$invoiceItem = new InvoiceItem($pastry, $quantity);
//            echo  count($invoice->getItems()->getItems()) . '/'. $invoiceSize . ' :' . $invoiceItem . '<br>' . PHP_EOL;
            $invoice->getItems()->addItem(
                new InvoiceItem(
                    $inventory->getItems()[array_rand($inventory->getItems())],
                    rand(self::MINIMUM_SIZE, self::MAXIMUM_SIZE)
            ));
            //echo 'number: ' . count($invoice->getItems()->getItems()) . '/'. $invoiceSize . ' <br>' . PHP_EOL ;
            $counter++;
        }
        return $invoice;
    }
}