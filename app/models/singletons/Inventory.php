<?php declare(strict_types=1);

namespace app\models\singletons;

use app\models\abstracts\Model;
use app\models\abstracts\StoreItem;
use app\models\concretes\Product;
use App\Models\Concretes\Order;
use app\models\concretes\Pastry;
use App\Models\Concretes\User;
use app\models\lists\Products;
use App\Models\Lists\Orders;
use app\models\lists\Pastries;
use DateTime;
use Exception;

class Inventory extends Model {
    private static $instance;
    protected static Products $items;

    private function __construct () {
        parent::__construct();
        self::$items = new Products();
    }

    public static function getInstance (): Inventory {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getItems (): Products {
        return self::$items;
    }

    private function __clone () {}
    public function __wakeup () {}


    /**
     * @throws Exception
     */
    public function addPastry (Pastry $pastry, int $quantity=50): void {
//        if (array_key_exists($pastry->getid(), self::$inventory->getItems())) {
//            throw new Exception($pastry . ' is already recorded');
//        }
        self::$items->addProduct(new Product ($pastry, $quantity));
    }

    public function add (Product $item): void{
        self::$items->addProduct($item);
    }

    public function toTable (
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
    ): string {
        $elem ='<table id="inventoryTable">'
            . '<thead>'
            . '<tr>'
            . '<th>Id</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
//                . '<th>Average Rating</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach (self::$items->getList() as $id => $item) {
            $elem .= '<tr onclick="send(' . $id . ')">'
                . '<td>' . $id . '</td>'
                . '<td>' . $item->getPastry()->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
                . '<td>' . $item->getPastry()->getName() . '</td>'
                . '<td>' . $item->getPastry()->getDescription() . '</td>'
                . '<td>' . number_format($item->getPastry()->getPrice(), 2) . '</td>'
//                . '<td>' . $pastry->getReveiws(
//                    DateTime::createFromFormat('Y-m-d', '2020-01-01'),
//                    DateTime::createFromFormat('Y-m-d', '2029-01-01')
//                )->getAverageRating() . '</td>'
                . '</tr>';
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}