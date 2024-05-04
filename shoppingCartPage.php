<?php declare(strict_types=1);

use app\templates\Dashboard;
use app\templates\HTMLForm;
use app\templates\HTMLList;
use app\templates\HTMLSection;

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'data_loader.php';

$users = unserialize($_SESSION['users']);
$user = $users->randomUser();

$title = 'Your Shopping Cart ' . $user->printName();

echo HTMLSection::head('Your Shopping Cart ' . $user->printName()) . HTMLSection::navbar()
    . HTMLList::shoppingCart($user) . HTMLSection::footer();