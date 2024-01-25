<?php declare(strict_types=1);
namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\Pastry;
use DateTime;
use Exception;

class WishList extends Model {
    private array $wishes;

    public function __construct () {
        parent::__construct();
        $this->wishes = array();
    }

    public function getWishes (): Wish|array {
        return $this->wishes;
    }

    /**
     * @throws Exception
     */
    public function add (Pastry $pastry): void {
        if (array_key_exists($pastry->getId(), $this->wishes)) {
            throw new Exception(pastry()->getName() . '  is already in your wish list.');
        }
        $this->wishes[$pastry->getId()] = new Wish($pastry);
    }

    /**
     * @throws Exception
     */
    public function remove (Pastry $pastry): void {
        if (!array_key_exists($pastry->getId(), $this->wishes)) {
            throw new Exception($pastry->getName() . '  does not exist in your wish list it cannot be removed.');
        }
        unset($this->wishes[$pastry->getId()]);
    }

    public function search (Pastry $pastry): ?Wish {
        if(array_key_exists($pastry->getId(), $this->wishes))
            return $this->wishes[$pastry->getId()];
        return null;
    }

    public function filter (DateTime $startDate, DayTime $endDate): WishList {
        $matches = new WishList();
        foreach ($this->wishes as $id => $wish) {
            if ($this->wishes[$id]->getSubmitTime() >= $startDate && $this->wishes[$id]->getSubbmitTime() <= $endDate)
                $matches->add($wish);
        }
        return $matches;
    }

    public function __toString (): string {
        $string = '';
        foreach ($this->wishes as $id => $wish) {
            $string .= $this->wishes[$id];
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table class="wish-list-table" id="wish-list-table" name="wish-list-table">'
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
        foreach ($this->wishes as $id => $wish) {
            $elem .= $this->wishes[$id]->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}