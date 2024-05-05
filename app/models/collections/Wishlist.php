<?php declare(strict_types=1);
namespace app\models\collections;

use app\models\abstracts\Aggregation;
use app\models\abstracts\Model;
use app\models\concretes\Pastry;
use app\models\concretes\InventoryItem;
use app\models\concretes\Wish;
use app\utils\SerialNumber;
use DateTime;
use Exception;

class Wishlist extends Aggregation {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): Wish|array {
        return $this->list;
    }

    /**
     * @throws Exception
     */
    public function addWish (Pastry $pastry): void {
        if (!is_null($this->searchByPastry($pastry))) {
            throw new Exception($pastry->getName() . '  is already in your wish list.');
        }
        $id = SerialNumber::nextWishId();
        $this->list[$id] = new Wish(
            $id,
            $pastry,
            DateTime::createFromFormat(DATE_TIME_FORMAT, date(DATE_TIME_FORMAT))
        );
    }

    /**
     * @throws Exception
     */
    public function removeWish (Pastry $pastry): void {
        $wish = $this->searchByPastry($pastry);
        if (is_null($wish)) {
            throw new Exception($pastry->getName() . ' is not in the wishlist so it cannot be removed.');
        }
        unset($this->list[$wish->getId()]);
    }

    public function searchByPastry (Pastry $pastry): ?Wish {
        foreach ($this->list as $id => $wish) {
            if ($wish->getPastry()->equals($pastry)) {
                return $wish;
            }
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function filterByDate (DateTime $startDate, DaTeTime $endDate): Wishlist {
        $matches = new Wishlist();
        foreach ($this->list as $wish) {
            if ($wish->getSubmitTime() >= $startDate && $wish->getSubbmitTime() <= $endDate)
                $matches->addWish($wish);
        }
        return $matches;
    }

    public function __toString (): string {
        $string = 'Wishes' . PHP_EOL;
        foreach ($this->list as $wish) {
            $string .= $wish . PHP_EOL;
        }
        return nl2br($string);
    }

    public function tableHeader (): string {
        return '<table id="wishlistTable">'
            . '<thead>'
            . '<tr>'
            . '<th>Date Added</th>'
            . '<th>Id</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '<th>Quantity</th>'
            . '</tr></thead>';
    }

    public function toTable (): string {
        $elem = $this->tableHeader();
        foreach ($this->list as $id => $wish) {
            $elem .= $this->list[$id]->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }

    public function random (): Wish { return $this->list[array_rand($this->list)]; }
}