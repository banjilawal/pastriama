<?php declare(strict_types=1);

namespace app\templates;

define ('USER_ORDERS_PAGE', 'userOrders.php');
define ('USER_WISHES_PAGE', 'userWishes.php');
define ('USER_ADDRESSES_PAGE', 'userAddresses.php');
define ('USER_CREDIT_CARDS_PAGE', 'userAddresses.php');
define ('ACCOUNT_SECURITY_PAGE', 'accountSecurity.php');

use app\enums\ListTag;
use app\enums\StylingClass;
use app\models\abstracts\Product;
use app\models\collections\Reviews;
use app\models\concretes\CreditCard;
use app\models\concretes\InventoryItem;
use app\models\concretes\Order;
use app\models\concretes\Pastry;
use app\models\concretes\review;
use app\models\concretes\User;
use app\models\concretes\Wish;
use app\utils\Convert;
use app\utils\Create;

class Script {

    public static function welcomePage (): string {
        return '<script>'
            . 'function rowClickHandler (id) {'
            . 'let cookie = document.cookie = "productId=" + id + "";' // + "; max-age=5";'
            . 'alert(cookie);'
            . 'location.href = "productPage.php";'
            . '}'
            . '</script>';
    }

}