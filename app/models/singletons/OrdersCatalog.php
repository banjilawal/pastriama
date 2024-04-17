<?php declare(strict_types=1);

namespace app\models\singletons;

use app\models\abstracts\Model;
use App\Models\Concretes\Order;
use App\Models\Concretes\User;
use App\Models\Lists\Orders;
use DateTime;
use Exception;

class OrdersCatalog extends Model {
    private static $instance;
    protected static Orders $orders;

    private function __construct () {
        parent::__construct();
        self::$orders = new Orders();
    }

    public static function getInstance(): OrdersCatalog {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone () {}
    public function __wakeup () {}

    public static function getOrders(): Orders {
        return self::$orders;
    }

    /**
     * @throws Exception
     */
    public function add (Order $order): void {
        self::$orders->addOrder($order);
    }
//
//    /**
//     * @throws Exception
//     */
//    public function filterByDate (DateTime $startDate, DateTime $endDate): Orders {
//        return self::$orders->filterByDateRange($startDate, $endDate);
//    }
//
//    /**
//     * @throws Exception
//     */
//    public static function userSearch (User $user, DateTime $startDate, DateTime $endDate): Orders {
//        return (self::$orders->filterByDateRange($startDate, $endDate))->filterByUser($user);
//    }
}