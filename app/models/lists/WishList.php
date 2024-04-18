<?php declare(strict_types=1);
namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\Pastry;
use app\models\concretes\Wish;
use DateTime;
use Exception;

class WishList extends Model {
    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): Wish|array {
        return $this->items;
    }

    /**
     * @throws Exception
     */
    public function add (Pastry $pastry): void {
        if (array_key_exists($pastry->getId(), $this->items)) {
            throw new Exception($pastry->getName() . '  is already in your wish list.');
        }
        $this->items[$pastry->getId()] = new Wish($pastry);
    }

    /**
     * @throws Exception
     */
    public function remove (Pastry $pastry): void {
        if (!array_key_exists($pastry->getId(), $this->items)) {
            throw new Exception($pastry->getName()
                . ' does not exist in your wish list it cannot be removed.');
        }
        unset($this->items[$pastry->getId()]);
    }

    public function search (Pastry $pastry): ?Wish {
        if(array_key_exists($pastry->getId(), $this->items))
            return $this->items[$pastry->getId()];
        return null;
    }

    /**
     * @throws Exception
     */
    public function filter (DateTime $startDate, DaTeTime $endDate): WishList {
        $matches = new WishList();
        foreach ($this->items as $wish) {
            if ($wish->getSubmitTime() >= $startDate && $wish->getSubbmitTime() <= $endDate)
                $matches->add($wish);
        }
        return $matches;
    }

    public function __toString (): string {
        $string = '';
        foreach ($this->items as $wish) {
            $string .= nl2br($wish);
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table id="wishesTable">'
            . '<thead>'
            . '<tr>'
            . '<th></th>'
            . '<th>Date Added</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $id => $wish) {
            $elem .= $this->items[$id]->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}