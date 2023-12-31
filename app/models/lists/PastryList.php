<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use App\models\concretes\Pastry;
use Exception;

class PastryList extends Model {
    private array $pastries;

    public function __construct () {
        parent::__construct();
        $this->pastries = array();
    }

    public function getPastries (): Pastry|array {
        return $this->pastries;
    }

    /**
     * @throws Exception
     */
    public function addPastries (PastryList $pastries): void {
        foreach ($pastries as $id => $pastry) {
            $this->add($pastry);
        }
    }

    /**
     * @throws Exception
     */
    public function add (Pastry $pastry): void {
        if (array_key_exists($pastry->getId(), $this->pastries)) {
            throw new Exception($pastry->getId() . ' is already in the list');
        }
        $this->pastries[$pastry->getId()] = $pastry;
    }

    /**
     * @throws Exception
     */
    public function removePastries (PastryList $pastries): void {
        foreach ($pastries as $id => $pastry) {
            $this->remove($pastry);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (Pastry $pastry): void {
        $id = $pastry->getId();
        if (!array_key_exists($id, $this->pastries)) {
            throw new Exception($pastry->getName() . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->pastries[$id]);
    }

    public function search (string $name): ?Pastry {
        foreach ($this->pastries as $id => $pastry) {
            if ($this->pastries[$id]->getName() === $name)
                return $this->pastries[$id];
        }
        return null;
    }

    public function __toString  (): string {
        $string = 'Pastries' . PHP_EOL;
        foreach ($this->pastries as $id => $pastry) {
            $string  .= $this->pastries[$id] . PHP_EOL;
        }
        return $string;
    }

    public function toTable (int $imageWidth, int $imageHeight): string {
        $elem ='<table class="pastry-table" id="pastry-table" name="pastry-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->pastries as $id => $pastry) {
            $elem .= $this->pastries[$id]->toRow($imageWidth, $imageHeight);
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}