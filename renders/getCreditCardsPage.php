<?php declare(strict_types=1);

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
} else {
    session_start();
}

require_once '..\bootstrap.php';

use app\pages\user\CreditCardsPage;


$user = unserialize($_SESSION['user']);
echo $user;

$page = new CreditCardsPage($user->getCreditCards(), 'Your Credit Cards ' . $user->getFirstname());
try {
    echo $page->getPage();
} catch (Exception $e) {
    echo $e;
}