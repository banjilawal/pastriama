<?php
namespace Shop\Model\collections;

use Exception;
use models\concretes\Wish;

class WishList {

    private array $wishes;
    

    public function __construct () {
        $this->wishes = array();
    }


    public function getWishes (): array {
        return $this->wishes;
    }


    /**
     * @throws Exception
     */
    public function add (Wish $wish): void {
        $id = $wish->getId();
        if (array_key_exists($id, $this->wishes) || !is_null($this->search($wish->getPastry()))) {
            throw new Exception($wish->getPastry()->getName() . '  is already in your wish list.');
        }
        $this->wishes[$id] = $wish;
    }


    /**
     * @throws Exception
     */
    public function remove (Wish $wish): void {
        $id = $wish->getId();
        if (!array_key_exists($id, $this->wishes) || is_null($this->search($wish->getPastry()))) {
            throw new Exception($wish>getPastry()->getName() . '  does not exist in your wish list it cannot be removed.');
        }
        unset($this->wishes[$id]);
    }


    public function search (Pastry $pastry): ?Wish {
        foreach ($this->wishes as $id => $wish) {
            if ($wish->getPastry()->equals($pastry))
                return $pastry;
        }
        return null;
    }


    public function filter (DateTime $startDate, DayTime $endDate): WishList {
        $matches = new WishList();
        foreach ($this->wishes as $id => $wish) {
            if ($wish->getSubmitTime() >= $startDate && $wish->getSubbmitTime() <= $endDate)
                $matches->add($wish);
        }
        return $matches;
    }


    public function __toString (): string {
        $string = '';
        foreach ($this->wishes as $item) {
            $string .= nl2br($item);
        }
        return $string;
    }

    
    public function toTable (): string {
        $tableName = 'wishList-' . $this->getId() . '-table';
        $elem = '<table class="' . 'wishList-table' . '" id="' . $tableName . '" name="' . $tableName . '">'
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
        foreach ($this->wishes as $item) {
            $elem .= $item->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
} // end class WishList