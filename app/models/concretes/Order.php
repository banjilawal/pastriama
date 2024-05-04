<?php declare(strict_types=1);

namespace app\models\concretes;



use app\models\abstracts\Entity;
use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;
use app\models\catalogs\Inventory;
use DateTime;
use Exception;

class Order extends Entity {

    private User $user;
    private array $items;
    private CreditCard $creditCard;
    private string $recipientName;
    private PostalAddress $deliveryAddress;
    private DateTime $timestamp;
    private DateTime $deliveryDate;

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
        $this->user = $user;
        $this->creditCard = $creditCard;
        $this->recipientName = $recipientName;
        $this->deliveryAddress = $shipToAddress;
        $this->timestamp = $submissionTime;
        $this->deliveryDate = UNDELIVERED_DATE;
        $this->items = array ();
    }

    public function getUser (): User {
        return $this->user;
    }

    public function getCreditCard (): CreditCard {
        return $this->creditCard;
    }

    public function getTimestamp (): \DateTime {
        return $this->timestamp;
    }

    public function getDeliveryDate (): ?DateTime {
        return $this->deliveryDate;
    }

    public function getItems (): OrderItem|array {
        return $this->items;
    }

    public function getRecipientName (): string {
        return $this->recipientName;
    }

    public function getDeliveryAddress (): PostalAddress {
        return $this->deliveryAddress;
    }

    public function getDeliveryEstimate (): DateTime {
        return $this->timestamp->modify('+ ' . DELIVERY_WINDOW . ' days');
    }

    public function getSubTotal (): float {
        $subTotal = 0.00;
        foreach ($this->items as $item) {
            $subTotal += $item->getCost();
        }
        return $subTotal;
    }

    public function getTax (): float {
        return $this->getSubTotal() * DEFAULT_TAX_PERCENTAGE / 100;
    }

    public function getTotalCharge (): float  {
        return $this->getSubTotal() + $this->getTax();
    }

    public function setDeliveryDate (DateTime $deliveryDate): void {
        $this->deliveryDate = $deliveryDate;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Order) {
            return parent::equals($object)
                && $this->user->equals($object->getUser())
                && $this->creditCard->equals($object->getCreditCard())
                && $this->recipientName === $object->getRecipientName()
                && $this->timestamp === $object->getTimestamp()
                && $this->deliveryAddress->equals($object->getDeliveryAddress());
        }
        return false;
    }

    public function __toString (): string {
        $string = PHP_EOL . 'order id:' . $this->getId()
            . ' customer:' . $this->user->printName()
            . ' Deliver to:' . $this->recipientName . ' ' . $this->deliveryAddress
            . ' submission date:' . $this->getTimestamp()->format(DATE_TIME_FORMAT)
            . ' total items=' . count($this->items)
            . ' ' . $this->printDeliveryDate();
        foreach ($this->items as $item) {
            $string .= PHP_EOL . $item;
        }
        $string .= PHP_EOL . 'sub total:' . $this->getSubTotal()
            . PHP_EOL . 'tax:' . $this->getTax()
            . PHP_EOL . 'total:' . $this->getTotalCharge() . PHP_EOL;
        return $string;
    }

    public function getNumberOfItems (): int {
        $totalItems = 0;
        foreach ($this->items as $item) {
            $totalItems += $item->getQuantity();
        }
        return $totalItems;
    }

    public function printDeliveryDate (): string {
        if ($this->deliveryDate === UNDELIVERED_DATE)
            return 'estimated delivery on ' . $this->getDeliveryEstimate()->format(DATE_FORMAT);
        return 'delivered on: ' . $this->deliveryDate->format(DATE_FORMAT);
    }

    private function addHelper (StoreItem $item): void {
        $product = $item->getProduct();
        $quantity = $item->getQuantity();
        $id = $product->getId();
        if ($this->contains($product)) {
            $this->items[$id]->increaseQuantity(abs($quantity));
        } else {
            try {
                $this->items[$id] = new OrderItem($product, abs($quantity));
            } catch (Exception $e) { echo $e; }
        }
    }

    /**
     * @throws Exception
     */
    public function add (Product $product, int $amount): void {
        $item = null;
        $id = $product->getId();
        $cartQuantity = $this->user->getCart()->getQuantity($product);
        if ($cartQuantity <= 0) {
            $this->addHelper(Inventory::getInstance()->remove($product, $amount));
        } else if ($cartQuantity > 0 && $cartQuantity < $amount) {
            $this->addHelper($this->getUser()->getCart()->remove($product, $cartQuantity));
            $this->addHelper(Inventory::getInstance()->remove($product, abs($amount- $cartQuantity)));
        } else {
            $this->addHelper($this->getUser()->getCart()->remove($product, $amount));
        }
    }

    /**
     * @throws Exception
     */
    public function remove (Product $product, int $amount): CartItem {
        $id = $product->getId();
        if ($amount - $this->getQuantity($product) <= 0) {
            throw new Exception ('There is an insufficient amount of ' . $product . ' to meet the request');
        }
        $this->items[$id]->decreaseQuantity($amount);
        if ($this->items[$id]->getQuantity() <= 0) {
            unset( $this->items[$id]);
        }
        return new CartItem($product, $amount, new DateTime());
    }

    public function searchByName (string $name): ?InventoryItem {
        foreach ($this->items as $id => $item) {
            if ($this->items[$id]->getProduct()->getName() === $name) {
                return $this->items[$id];
            }
        }
        return null;
    }

    public function searchByProduct (Product $product): ?InventoryItem {
        foreach ($this->items as $id => $item) {
            if ($this->items[$id]->getProduct()->equals($product)) {
                return $this->items[$id];
            }
        }
        return null;
    }

    public function searchById (int $id): ?InventoryItem {
        if (array_key_exists($id, $this->items))
            return $this->items[$id];
        return null;
    }

    public function contains (Product $product): bool {
        return (array_key_exists($product->getId(), $this->items));
    }

    public function amountExists (Product $product, int $amount): bool {
        $id = $product->getId();
        return array_key_exists($id, $this->items) && $this->items[$id]->getQuantity >= $amount;
    }

    public function getQuantity (Product $product): int {
        if (!$this->contains($product))
            return PHP_INT_MIN;
        else
            return $this->items[$product->getId()]->getQuantity();
    }

    public function randomOrder (): Order {
        return $this->items[array_rand($this->items)];
    }
}