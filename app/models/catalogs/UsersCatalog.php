<?php declare(strict_types=1);

namespace app\models\catalogs;

use app\models\abstracts\Model;
use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;
use app\models\collections\Reviews;
use app\models\collections\Users;
use app\models\concretes\CartItem;
use app\models\concretes\InventoryItem;
use App\Models\Concretes\Order;
use app\models\concretes\Pastry;
use App\Models\Concretes\User;
use app\models\collections\InvoiceItems;
use App\Models\collections\Orders;
use app\models\collections\Pastries;
use DateTime;
use Exception;

class UsersCatalog extends Model {
    private static $instance;
    protected Users $users;

    private function __construct () {
        parent::__construct();
        $this->users = new Users();
    }

    public static function getInstance (): UsersCatalog {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone () {}
    public function __sleep() {
        // Returning an empty array prevents serializing instance variables
        return [];
    }

    public function __wakeup() {
        // When unserialized, ensure the singleton pattern is maintained
        // then reinstate the instance.
        self::$instance = $this;
    }

    public function getUsers (): Users {
        return $this->users;
    }
}