<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\StoreItem;
use app\models\lists\Products;
use app\processors\Process;
use app\service\requests\AddShippingAddressRequest;
use DateTime;
use Exception;

class Order extends Entity {
//    protected static DateTime $defaultDeliveryDate;
    public const ESTIMATED_TRANSIT_DAYS = 5;
    private User $user;
    private CreditCard $creditCard;

//    private DateTime $invalidDeliveryDate;
    private Products $invoice;
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
        $this->submissionTime = $submissionTime; //new DateTime('now');
//        $this->invalidDeliveryDate = new DateTime('2525-01-01');
//        self::$defaultDeliveryDate = new DateTime('2525-01-01');
        $this->dateDelivered = UNDELIVERED_DATE; //::$defaultDeliveryDate;
        //$this->submissionTime = DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
        //$this->realDelivery = DateTime::createFromFormat('U', date('Y-m-d H:i:s')); //null;
        $this->invoice = new Products();



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

    public function getInvoice (): Products {
        return $this->invoice;
    }

    public function getRecipientName (): string {
        return $this->recipientName;
    }

    public function getShipToAddress (): PostalAddress {
        return $this->shipToAddress;
    }

    public function getProjectedDelivery (): DateTime {
        return $this->submissionTime->modify('+ ' . self::ESTIMATED_TRANSIT_DAYS . ' days');
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
        if ($object instanceof Order) {
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
        $string = parent::__toString() . ' customer:' . $this->user->printName()
            . ' Deliver to:' . $this->recipientName . ' ' . $this->shipToAddress
            . ' submission date:' . $this->getSubmissionTime()->format('Y-m-d  H:i:s')
            . ' total items=' . count($this->invoice->getProducts()) . PHP_EOL;
        foreach ($this->invoice->getProducts() as $item) {
            $string .=  $item .PHP_EOL;
//            echo 'item is ' . $item->getName();
        }
        $string .= 'total:' . $this->getInvoice()->getTotalCharge() . PHP_EOL . $this->printDeliveryDate();
        return $string;
    }

    public function printDeliveryDate (): string {
        if ($this->dateDelivered === UNDELIVERED_DATE)
            return 'estimated delivery on ' . $this->getProjectedDelivery()->format('Y-m-d');
        return 'delivered on: ' . $this->dateDelivered->format('Y-m-d');
    }

    public function search (Pastry $pastry): ?InventoryItem {
        foreach ($this->invoice as $id => $item) {
            if (!is_null($item->find($pastry)))
                return $this->invoice[$item->getId()];
        }
        return null;
    }

    public function toRow (): string {
        return '<tr>' // onclick="rowClickHandler($row)">'
//            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
//            . '<td>' .  $this->creditCard->toString() .'</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '<td>' . number_format($this->invoice->getTotalCharge(), 2) . '</td></tr>';
//            . '<td>' . $this->recipientName . ' ' . $this->shipToAddress . '</td>';
    }

    public function toTable (): string {
        $elem = '<table id="order_' . $this->getId() . '_table"' . '>'
            . '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Name</th>'
            . '<th>Picture</th>'
            . '<th>Price</th>'
            . '<th>Quantity</th>'
            . '<th>Cost</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
//            . '<tr>'
//            . '<td>' . $this->getId() . '</td>'
//            . '<td>' . $this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname() . '</td>'
//            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s'). '</td>'
//            . '<td>' . $this->printDeliveryDate() . '</td>'
//            . '</tr>';
//        $elem .= $this->items->toTable();
        foreach ($this->invoice->getProducts() as $item) {
            $elem .= '<tr>'
                . '<td>' . $item->getId() . '</td>'
                . '<td>' . $item->getPastry()->getName() . '</td>'
                . '<td>' . $item->getPastry()->getImgTag() . '</td>'
                . '<td>' . number_format($item->getPastry()->getPrice(), 2) . '</td>'
                . '<td>' . $item->getQuantity() . '</td>'
                . '<td>' . $item->getCost() . '<td>'
                . '</tr>'; //</strong></td></tr></tr>' $item->toRow(
//                StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
//                StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
//            );
        }
//
//                    . '<td>' . $this-> . '</td>'
//            . '<td>' . $this->getName() . '</td>'
//            . '<td>' . $this->description . '</td>'
//            . '<td>' . number_format($this->price, 2) . '</td>'
//            . '</tr>'
        $elem .= '<tr><td>Subtotal</td><td></td><td></td><td></td><td></td><td>' . number_format($this->invoice->getSubTotal(), 2) . '</td></tr>'
            . '<tr><td>Tax</td><td></td><td></td><td></td><td></td><td>' . number_format($this->invoice->getTax(), 2) . '</td></tr>'
            . '<tr><td>Total Charge</td><td></td><td></td><td></td><td></td><td>' . number_format($this->invoice->getTotalCharge(), 2)  . '</td></tr>'
            . '</tr></tbody></table>';
        return $elem;
    }
}