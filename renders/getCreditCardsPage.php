<?php declare(strict_types=1);

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
} else {
    session_start();
}

require_once '..\bootstrap.php';

use app\elements\user\CreditCardsPageElement;


$user = unserialize($_SESSION['user']);
echo $user;

$page = new CreditCardsPageElement($user->getCreditCards(), 'Your Credit Cards ' . $user->getFirstname());
try {
    echo $page->page();
} catch (Exception $e) {
    echo $e;
}