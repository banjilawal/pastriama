<?php declare(strict_types=1);

use app\models\concretes\NewOrder;
use app\models\concretes\InventoryItem;
use app\test\NewEntityGenerator;
use app\utils\SerialNumber;

if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

echo nl2br(print_r($_POST['quantity']) . ' processAddToCartForm.php' . PHP_EOL);
echo nl2br(print_r($_SESSION['pastry']) . ' processAddToCartForm.php' . PHP_EOL);

$user = unserialize($_SESSION['user']);
$pastry = unserialize($_SESSION['pastry']);
//$creditCard = $user->getCreditCards()->getItems()[array_rand($user->getCreditCards()->getItems())];
$creditCard = $user->getCreditCards->randomCard();

$shoppingCart = null;
if (!isset($_SESSION['shoppingCart'])) {
    try {
        $shoppingCart = new NewOrder(
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