<?php declare(strict_types=1);

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
} else {
    session_start();
}

require_once '..\bootstrap.php';
use app\pages\ProductPage;

//$user = null;
//if (array_key_exists('user', $_SESSION)) {
//    $user = unserialize($_SESSION['user']);
//    echo $user;
//}

$product = unserialize($_SESSION['products'])->searchById((int) $_COOKIE['productId']);
$reviews = unserialize($_SESSION['reviews']); //)->filterByPastry($inventoryItem->getPastry());

$page = new ProductPage($product);
try {
    echo $page->page();
} catch (Exception $e) {
    echo $e;
}