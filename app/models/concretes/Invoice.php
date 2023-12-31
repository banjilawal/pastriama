<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\StoreItem;
use DateTime;

class Invoice extends Entity {

    public const ESTIMATED_TRANSIT_DAYS = 5;
    private User $user;
    private CreditCard $creditCard;
    private DateTime $submissionTime;
    private DateTime $realDelivery;
    private InvoiceItemList $items;

    public function __construct (int $id, User $user, CreditCard $creditCard) {
        parent::__construct($id);
        $this->user = $user;
        $this->creditCard = $creditCard;
        $this->submissionTime = DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
        $this->realDelivery = null;
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

    public function getRealDelivery (): ?DateTime {
        return $this->realDelivery;
    }

    public function getItems (): InvoiceItemList {
        return $this->items;
    }

    public function getProjectedDelivery (): DateTime {
        return $this->submissionTime->modify('+ ' . self::ESTIMATED_TRANSIT_DAYS . ' days');
    }

    public function setRealDelivery (DateTime $deliveryDate): void {
        $this->realDelivery = $deliveryDate;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Invoice) {
            return parent::equals($object)
                && $this->customer === $object->getCustomer()
                && $this->creditCard->equals($object->getCreditCard())
                && $this->submissionTime === $object->getSubmissionTime();
        }
        return false;
    }

    public function __toString (): string {
        $string = '' . PHP_EOL;
        foreach ($this->items as $item) {
            $string .=  $item .PHP_EOL;
        }
        return $string;
    }

    public function printDeliveryDate (): string {
        if (is_null($this->realDelivery))
            return 'estimated delivery on ' . $this->getProjectedDelivery()->format('Y-m-d');
        return $this->realDelivery->format('Y-m-d');
    }

    public function search (Pastry $pastry): ?InvoiceItem {
        foreach ($this->items as $id => $item) {
            if (!is_null($item->find($pastry)))
                return $this->items[$item->getId()];
        }
        return null;
    }

    public function toRow (): string {
        return '<tr class="invoice-row" id="invoice-row" name="invoice-row">'
//            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
//            . '<td>' .  $this->creditCard->toString() .'</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s'). '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '<td>' . $this->items->getTotal(). '</td></tr>';
    }

    public function toTable (): string {
        $elem = '<table class="invoice-table" id="invoice-table" name="invoice-table">'
            . '<thead>'
            . '<tr>'
            . '<th>id</th>'
            . '<th>Customer</th>'
            . '<th>Submission Date</th>'
            . '<th>Delivery</th>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->getCustomer()->getFirstname() . ' ' . $this->getCustomer()->getLastname() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s'). '</td>'
            . '<td>' . $this->printDeliveryDate() . '</td>'
            . '</tr>';
        foreach ($this->items as $item) {
            $elem .= $item->toRow(
                StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
                StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
            );
        }
        $elem .= '<tr>'
            . '<td>Cost</td><td>' . $this->items->getSubTotal() . '</td>'
            . '<td>Tax</td><td>' . $this->items->getTax() . '</td>'
            . '<td>Total Charge</td><td>' . $this->items->getTotal() . '</td>'
            . '</tr></tbody></table>';
        return $elem;
    }
}