<?php declare(strict_types=1);

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
} else {
    session_start();
}

require_once '..\bootstrap.php';
use app\elements\ProductPageElement;

echo  nl2br(print_r($_COOKIE['productId']) . PHP_EOL);
echo nl2br( print_r(array_keys($_SESSION)) . PHP_EOL);
//echo println('reviews' . PHP_EOL . print_r($_SESSION['reviews']));
//$reviews = unserialize($_SESSION['reviews']);
//echo count($reviews->getList()) . PHP_EOL . unserialize($_SESSION['reviews']);
//$user = null;
//if (array_key_exists('user', $_SESSION)) {
//    $user = unserialize($_SESSION['user']);
//    echo $user;
//}

$reviewsCatalog = unserialize($_SESSION['reviewsCatalog']);
//echo print_r(unserialize($_SESSION['products'])->getList());
$product = unserialize($_SESSION['products'])->searchById((int) $_COOKIE['productId']); //->searchById((int) $_COOKIE['productId']);
 //)->filterByPastry($inventoryItem->getPastry());
//echo println('reviews' . PHP_EOL . unserialize($_SESSION['reviews'])->filterByPastry($product->getPastry()));
$page = new ProductPageElement($product);
try {
    echo $page->page();
} catch (Exception $e) {
    echo $e;
}