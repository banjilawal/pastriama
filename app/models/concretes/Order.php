<?php declare(strict_types=1);

namespace app\models\concretes;

define ('ESTIMATED_TRANSIT_DAYS', 5);
define ('DAYS_FOR_REFUND', 30);

use app\enums\StylingClass;
use app\models\abstracts\Entity;
use app\models\collections\InvoiceItems;
use app\query\select\clause\where\NumberClause;
use DateTime;
use Exception;

class Order extends Entity {
//    protected static DateTime $defaultDeliveryDate;

    private User $user;
    private CreditCard $creditCard;

//    private DateTime $invalidDeliveryDate;
    private InvoiceItems $invoice;
    private string $recipientName;
    private PostalAddress $shipToAddress;
    private DateTime $submissionTime;
    private DateTime $dateDelivered;

    /**
     * @throws Exception
     */
    public function __construct (
        int $id,
        User $user,
        CreditCard $creditCard,
        string $recipientName,
        PostalAddress $shipToAddress,
        DateTime $submissionTime,
    ) {
        parent::__construct($id);
//        if ($this->user->getShippingAddresses()->getArrayIndex($shipToAddress) > PHP_INT_MIN) {
//            Process::addShippingAddress(new AddShippingAddressRequest($user, $shipToAddress));
//        }
        $this->user = $user;
        $this->creditCard = $creditCard;
        $this->recipientName = $recipientName;
        $this->shipToAddress = $shipToAddress;
        $this->submissionTime = $submissionTime;
        $this->dateDelivered = UNDELIVERED_DATE;
        $this->invoice = new InvoiceItems();
//        if (empty(trim($recipientName)) || $recipientName === $user->getName()) {
//            $this->recipientName = $user->getName();
//        }
//        else {
//            $this->recipientName = $recipientName;
//        }
    }

    public function getUser (): User {
        return $this->user;
    }

    public function getCreditCard (): CreditCard {
        return $this->creditCard;
    }

    public function getSubmissionTime (): \DateTime {
        return $this->submissionTime;
    }

    public function getDateDelivered (): ?DateTime {
        return $this->dateDelivered;
    }

    public function getInvoice (): InvoiceItems {
        return $this->invoice;
    }

    public function getRecipientName (): string {
        return $this->recipientName;
    }

    public function getShipToAddress (): PostalAddress {
        return $this->shipToAddress;
    }

    public function getProjectedDelivery (): DateTime {
        return $this->submissionTime->modify('+ ' . ESTIMATED_TRANSIT_DAYS . ' days');
    }


    public function setDateDelivered (DateTime $deliveryDate): void {
        $this->dateDelivered = $deliveryDate;
    }

    /**
     * @throws Exception
     */
//    public function setShipToAddress (PostalAddress $shipToAddress): void {
//        if ($this->user->getShippingAddresses()->getArrayIndex($shipToAddress) > PHP_INT_MIN) {
//            Process::addShippingAddress(new AddShippingAddressRequest($this->user, $shipToAddress));
//        }
//        $this->shipToAddress = $shipToAddress;
//    }

//    public function setRecipientName (string $recipientName): void {
//        if (empty(trim($recipientName)) || $recipientName === $this->user->getName()) {
//            $this->recipientName = $this->user->getName();
//        }
//        else {
//            $this->recipientName = $recipientName;
//        }
//    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof NewOrder) {
            return parent::equals($object)
                && $this->user->equals($object->getUser())
                && $this->creditCard->equals($object->getCreditCard())
                && $this->recipientName === $object->getRecipientName()
                && $this->submissionTime === $object->getSubmissionTime()
                && $this->shipToAddress->equals($object->getShipToAddress());
        }
        return false;
    }

    public function __toString (): string {
        $string = 'id:' . $this->getId()
            . ' customer:' . $this->user->printName()
            . ' Deliver to:' . $this->recipientName . ' ' . $this->shipToAddress
            . ' submission date:' . $this->getSubmissionTime()->format(DATE_TIME_FORMAT)
            . ' total items=' . count($this->invoice->getList()) . PHP_EOL;
        foreach ($this->invoice->getList() as $item) {
            $string .=  $item .PHP_EOL;
//            echo 'item is ' . $item->getName();
        }
        $string .= 'total:' . $this->getInvoice()->getTotalCharge()
            . PHP_EOL . $this->printDeliveryDate();
        return $string;
    }

    public function printDeliveryDate (): string {
        if ($this->dateDelivered === UNDELIVERED_DATE)
            return 'estimated delivery on ' . $this->getProjectedDelivery()->format(DATE_FORMAT);
        return 'delivered on: ' . $this->dateDelivered->format(DATE_FORMAT);
    }

    public function toRow (): string {
        return '<tr id="orderId_' . $this->getId() . '" onclick="rowClickHandler(' . $this->getId() . ')">'
//            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
//            . '<td>' .  $this->creditCard->toString() .'</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format(DATE_TIME_FORMAT) . '</td>'
            . '<td>' . $this->recipientName . ' ' . $this->shipToAddress . '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '<td>' . number_format($this->invoice->getTotalCharge(), 2) . '</td></tr>';
    }

    private function orderItemDashboardHeading (InventoryItem $product): string {
        return '<div class="'. StylingClass::CONTAINER->value . '">'
            . '<table>'
            . '<thead>'
                . '<tr>'
                    . '<th>Order Placed</th>'
                    . '<th>Total</th>'
                    . '<th>Ship To</th>'
                    . '<th>Order #' . $this->getId() . '</th>'
                . '</tr>'
            . '</thead>'
            . '<tbody>'
                . '<tr>'
                . '<td>' .  $this->submissionTime->format(DATE_FORMAT) . '</td>'
                . '<td>' . number_format($product->getCost(), 2) . '</td>'
                . '<td>' . $this->shipToAddress . '</td>'
                . '<td><a href="orderPage.php">View order details</a></td>'
                . '</tr>'
            . '</tbody>'
            . '</table></div>';
    }

    private function orderItemDashboard (InventoryItem $product): string {
        return self::orderItemDashboardHeading($product)
            . '<div class"' . StylingClass::ORDER_ITEM_DASHBOARD->value . '">'
                . '<a href="productPage.php">' . $product->getPastry()->getName() . '</a>'
                . '<div class="' .  StylingClass::CONTAINER->value . '">'
                    . '<ul class="' . StylingClass::INTERACTIVE_LIST->value .  '">'
                        . '<li><a href="returnPage.php" class="'. StylingClass::BEVELED_LINK->value. '">Return Product</a></li>'
                    . '</ul>'
                .  '</div>'
            . '</div>';
    }

    public function tableHeader (): string {
        return '<table id="orderTable_' . $this->getId() . '">'
            . '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Submission Time</th>'
            . '<th>Delivery Address</th>'
            . '<th>Delivery Status</th>'
            . '<th>Total</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
    }

    public function toTable (): string {
        return $this->tableHeader() . '<tbody>' .$this->toRow() . '<tr>' . $this->invoice->toTable()
            . '</tr></tbody></table>';
//        $elem = '<table id="orderTable_' . $this->getId() . '">'
//            . '<thead>'
//            . '<tr>'
//            . '<th>id</th>'
//            . '<th>Name</th>'
//            . '<th>Picture</th>'
//            . '<th>Price</th>'
//            . '<th>Quantity</th>'
//            . '<th>Cost</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>';
//            . '<tr>'
//            . '<td>' . $this->getId() . '</td>'
//            . '<td>' . $this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname() . '</td>'
//            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s'). '</td>'
//            . '<td>' . $this->printDeliveryDate() . '</td>'
//            . '</tr>';
//        $elem .= $this->items->toTable();
//        foreach ($this->invoice->getProducts() as $item) {
//            $elem .= '<tr>'
//                . '<td>' . $item->getId() . '</td>'
//                . '<td>' . $item->getPastry()->getName() . '</td>'
//                . '<td>' . $item->getPastry()->getImgTag() . '</td>'
//                . '<td>' . number_format($item->getPastry()->getPrice(), 2) . '</td>'
//                . '<td>' . $item->getQuantity() . '</td>'
//                . '<td>' . $item->getCost() . '<td>'
//                . '</tr>'; //</strong></td></tr></tr>' $item->toRow(
//                Product::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
//                Product::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
//            );
//        }
//
//                    . '<td>' . $this-> . '</td>'
//            . '<td>' . $this->getName() . '</td>'
//            . '<td>' . $this->description . '</td>'
//            . '<td>' . number_format($this->price, 2) . '</td>'
//            . '</tr>'
//        $elem .= '<tr><td>Subtotal</td><td></td><td></td><td></td><td></td><td>' . number_format($this->invoice->getSubTotal(), 2) . '</td></tr>'
//            . '<tr><td>Tax</td><td></td><td></td><td></td><td></td><td>' . number_format($this->invoice->getTax(), 2) . '</td></tr>'
//            . '<tr><td>Total Charge</td><td></td><td></td><td></td><td></td><td>' . number_format($this->invoice->getTotalCharge(), 2)  . '</td></tr>'
//            . '</tr></tbody></table>';
//        return $elem;
    }
}