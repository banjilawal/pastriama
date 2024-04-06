<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\StoreItem;
use app\models\lists\InvoiceItemList;
use DateTime;

class Invoice extends Entity {

    public const ESTIMATED_TRANSIT_DAYS = 5;
    private User $user;
    private CreditCard $creditCard;
    private DateTime $submissionTime;
    private DateTime $realDeliveryDate;
    private InvoiceItemList $items;

    public function __construct (int $id, User $user, CreditCard $creditCard) {
        parent::__construct($id);
        $this->user = $user;
        $this->creditCard = $creditCard;
        $this->submissionTime = new DateTime('now');
        $this->realDeliveryDate = new DateTime('2027-01-01');
        //$this->submissionTime = DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
        //$this->realDelivery = DateTime::createFromFormat('U', date('Y-m-d H:i:s')); //null;
        $this->items = new InvoiceItemList();
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

    public function getRealDeliveryDate (): ?DateTime {
        return $this->realDeliveryDate;
    }

    public function getItems (): InvoiceItemList {
        return $this->items;
    }

    public function getProjectedDelivery (): DateTime {
        return $this->submissionTime->modify('+ ' . self::ESTIMATED_TRANSIT_DAYS . ' days');
    }

    public function setRealDeliveryDate (DateTime $deliveryDate): void {
        $this->realDeliveryDate = $deliveryDate;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Invoice) {
            return parent::equals($object)
                && $this->user === $object->getUser()
                && $this->creditCard->equals($object->getCreditCard())
                && $this->submissionTime === $object->getSubmissionTime();
        }
        return false;
    }

    public function __toString (): string {
        $string = 'INVOICE_TO_STRING (invoiceId:' . $this->getId()
            . ' customer:' . $this->user->printName()
            . ' submission date:' . $this->getSubmissionTime()->format('Y-m-d  H:i:s')
            . 'total_items=' . count($this->items->getItems())
            . ')' . PHP_EOL;

        foreach ($this->items->getItems() as $item) {
            $string .=  $item .PHP_EOL;
//            echo 'item is ' . $item->getName();
        }
//        $string . 'total:' . $this->getItems()->getTotalCharge();
        return $string;
    }

    public function printDeliveryDate (): string {
        if (is_null($this->realDeliveryDate))
            return 'estimated delivery on ' . $this->getProjectedDelivery()->format('Y-m-d');
        return $this->realDeliveryDate->format('Y-m-d');
    }

    public function search (Pastry $pastry): ?InvoiceItem {
        foreach ($this->items as $id => $item) {
            if (!is_null($item->find($pastry)))
                return $this->items[$item->getId()];
        }
        return null;
    }

    public function toRow (): string {
        return '<tr class="invoice-row" id="invoice-row" name="invoice-row" onclick="rowClickHandler($row)">'
//            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
//            . '<td>' .  $this->creditCard->toString() .'</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '<td>' . number_format($this->items->getTotalCharge(), 2) . '</td></tr>';
    }

    public function toTable (): string {
        $elem = '<table class="invoice-table" id="invoice-table" name="invoice-table">'
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
        foreach ($this->items->getItems() as $item) {
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
        $elem .= '<tr><td>Subtotal</td><td></td><td></td><td></td><td></td><td>' . number_format($this->items->getSubTotal(), 2) . '</td></tr>'
            . '<tr><td>Tax</td><td></td><td></td><td></td><td></td><td>' . number_format($this->items->getTax(), 2) . '</td></tr>'
            . '<tr><td>Total Charge</td><td></td><td></td><td></td><td></td><td>' . number_format($this->items->getTotalCharge(), 2)  . '</td></tr>'
            . '</tr></tbody></table>';
        return $elem;
    }
}