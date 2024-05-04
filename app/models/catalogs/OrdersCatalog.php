<?php declare(strict_types=1);

namespace app\models\catalogs;

use app\models\abstracts\Model;
use App\Models\Concretes\Order;
use App\Models\Concretes\User;
use App\Models\collections\Orders;
use DateTime;
use Exception;

final class OrdersCatalog extends Model {
    private static $instance;
    protected Orders $orders;

    private function __construct () {
        parent::__construct();
        $this->orders = new Orders();
    }

    public static function getInstance(): OrdersCatalog {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone () {}

    public function __sleep() {
        return []; // Returning an empty array prevents serializing instance variables
    }

    public function __wakeup() {
        // When unserialized, ensure the singleton pattern is maintained
        self::$instance = $this; // Reinstate the singleton instance
    }

    public function getOrders (): Orders {
        return $this->orders;
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