<?php declare(strict_types=1);

namespace app\models\catalogs;

use app\models\abstracts\Model;
use app\models\abstracts\Product;
use app\models\concretes\InventoryItem;
use App\Models\Concretes\NewOrder;
use app\models\concretes\Pastry;
use App\Models\Concretes\User;
use app\models\collections\InvoiceItems;
use App\Models\collections\Orders;
use app\models\collections\Pastries;
use DateTime;
use Exception;

class Inventory extends Model {
    private static $instance;
    protected static InvoiceItems $products;

    private function __construct () {
        parent::__construct();
        self::$products = new InvoiceItems();
    }

    public static function getInstance (): Inventory {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getProducts (): InvoiceItems {
        return self::$products;
    }

    private function __clone () {}
    public function __wakeup () {}


//    /**
//     * @throws Exception
//     */
//    public function addPastry (Pastry $pastry, int $quantity=50): void {
//        if (array_key_exists($pastry->getid(), self::$inventory->getItems())) {
//            throw new Exception($pastry . ' is already recorded');
//        }
//        self::$products->add($pastry, $quantity);
//    }

//    public function add (InvoiceItem $item): void{
//        self::$products->addProduct($item);
//    }

//    public function toTable (
//        int $imageWidth=Product::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
//        int $imageHeight=Product::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
//    ): string {
//        $elem ='<table id="inventoryTable">'
//            . '<thead>'
//            . '<tr>'
//            . '<th>Id</th>'
//            . '<th>Picture</th>'
//            . '<th>Name</th>'
//            . '<th>Description</th>'
//            . '<th>Price</th>'
////                . '<th>Average Rating</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>';
//        foreach (self::$products->getList() as $id => $item) {
//            $elem .= '<tr onclick="send(' . $id . ')">'
//                . '<td>' . $id . '</td>'
//                . '<td>' . $item->getPastry()->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
//                . '<td>' . $item->getPastry()->getName() . '</td>'
//                . '<td>' . $item->getPastry()->getDescription() . '</td>'
//                . '<td>' . number_format($item->getPastry()->getPrice(), 2) . '</td>'
//                . '<td>' . $pastry->getReveiws(
//                    DateTime::createFromFormat('Y-m-d', '2020-01-01'),
//                    DateTime::createFromFormat('Y-m-d', '2029-01-01')
//                )->getAverageRating() . '</td>'
//                . '</tr>';
//        }
//        $elem .= '</tbody></table>';
//        return $elem;
//    }
}