<?php declare(strict_types=1);

use app\models\concretes\Order;
use app\models\concretes\InventoryItem;
use app\test\EntityGenerator;
use app\utils\SerialNumber;

if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

echo nl2br(print_r($_POST['quantity']) . ' ' . PHP_EOL);
echo nl2br(print_r($_SESSION['pastry']) . ' ' . PHP_EOL);

$user = unserialize($_SESSION['user']);
$pastry = unserialize($_SESSION['pastry']);
//$creditCard = $user->getCreditCards()->getItems()[array_rand($user->getCreditCards()->getItems())];
$creditCard = EntityGenerator::pickCreditCard($user);

$shoppingCart = null;
if (!isset($_SESSION['shoppingCart'])) {
    try {
        $shoppingCart = new Order(
            SerialNumber::nextOrderId(),
            $user,
            $creditCard,
            $user->getName()
        );
    } catch (Exception $e) {
        echo $e;
    }
    $_SESSION['shoppingCart'] = serialize($shoppingCart); // Set a default value if needed
}
$shoppingCart = unserialize($_SESSION['shoppingCart']);
$shoppingCart->getItems()->addItem(new InventoryItem($pastry, (int) trim($_POST['quantity'])));
$_SESSION['shoppingCart'] = serialize($shoppingCart);


//$invoice->getItems()->addItem(new InvoiceItem($pastry, (int) trim($_POST['quantity'])));
//echo 'Current invoice:' . $invoice;
//$_SESSION['shoppingCart'] = serialize($invoice);