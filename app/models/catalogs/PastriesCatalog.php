<?php declare(strict_types=1);

namespace app\models\catalogs;

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

class PastriesCatalog extends Model {
    private static $instance;
    protected static Pastries $pastries;

    private function __construct () {
        parent::__construct();
        self::$pastries = new Pastries();
    }

    public static function getInstance (): PastriesCatalog {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    private function __clone () {}
    public function __wakeup () {}

    public static function getPastries (): Pastries {
        return self::$pastries;
    }
}