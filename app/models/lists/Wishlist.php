<?php declare(strict_types=1);
namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\Pastry;
use app\models\concretes\Product;
use app\models\concretes\Wish;
use DateTime;
use Exception;

class Wishlist extends Model {
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
        if (array_key_exists($id, $this->list)) {
            throw new Exception($product->getPastry()->getName() . '  is already in your wish list.');
        }
        $this->list[$id] = new Wish($product, DateTime::createFromFormat(DATE_TIME_FORMAT, date(DATE_TIME_FORMAT)));
    }

    /**
     * @throws Exception
     */
    public function removeWish (Product $product): void {
        if (is_null($this->searchById($product->getId()))) {
            throw new Exception($product->getPastry()->getName() . ' is not in the wishlist so it cannot be removed.');
        }
        unset($this->list[$product->getId()]);
    }

    public function searchById (int $id): ?Wish {
        if (array_key_exists($id, $this->list))
            return $this->list[$id];
        return null;
    }

    public function searchByProductName (string $name): ?Wish {
        foreach ($this->list as $wish) {
            if ($wish->getProduct()->getPastry()->getName() === $name)
                return $wish;
        }
        return null;
    }

    public function searchByProduct (Product $product): ?Wish {
        return $this->searchById($product->getId());
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
}