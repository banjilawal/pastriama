<?php declare(strict_types=1);

use app\templates\Dashboard;
use app\templates\HTMLSection;

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

//require_once 'processors\processLoginForm.php';
require_once 'data_loader.php';


$users = unserialize($_SESSION['users']);
$inventory = unserialize($_SESSION['inventory']);
//print_r($inventory->getItems());
//print_r($users->getUsers()->getList());
//print_r($users->getUsers()->getList());
$user = $users->randomUser(); // . PHP_EOL);
print_r(array_keys($_SESSION));
//echo $user;

//print_r($_SESSION['user']);

$title = 'Welcome to Your Dashboard ' . $user->printName();
echo HTMLSection::head($title) . HTMLSection::navbar()
    . Dashboard::user($user) . HTMLSection::footer();

//echo print_r($_SESSION['user']);
////$user = unserialize($_SESSION['user']);
////echo $user;
//$pageTitle = 'Welcome to Your Dashboard ';// . $user->printName();
//require_once 'old_things_2024_04_23\pages_2024_04_23\WebPage.php';
//
//use app\models\concretes\User;
//
//class userDashboard extends old_things_2024_04_23\pages_2024_04_23\WebPage {
//    private User $user;
//
//    public function __construct (User $user) {
//        parent::__construct('Hello ' . $user->getFirstname());
//        $this->user = $user;
//    }
//
//    public function getUser (): User {
//        return $this->user;
//    }
//}


//$datasets = null;
//try {
//    $datasets = ListGenerator::lists();
//} catch (Exception $e) {
//    echo $e . '<br>' . PHP_EOL;
//}
//foreach($datasets['users']->getItems() as $user) {
//    echo $user . PHP_EOL;
//}
//
//foreach($datasets['pastries']->getItems() as $pastry) {
//    echo $pastry . PHP_EOL;
//}

//$_SESSION['datasets'] = serialize($datasets);
//$user = $datasets['users']->getItems()[array_rand($datasets['users']->getItems())];
//$userInvoices = $datasets['invoices']->filterByUser($user);
//$userReviews = $datasets['reviews']->filterByUser($user);
//
//$_SESSION['pastries'] = serialize($datasets['pastries']);
//$_SESSION['user'] = serialize($user);
//$_SESSION['userInvoices'] = serialize($userInvoices);
//$_SESSION['userReviews'] = serialize($userReviews);



//$users = null;
//try {
//    $users = ListGenerator::userList(15);
//} catch (Exception $e) {
//}
//$user = $users->searchById(array_rand($users->getItems()));

//$pastries = null;
//try {
//    $pastries = ListGenerator::pastryList(40);
//} catch (Exception $e) {
//}
//echo 'Number of pastries:' . count($pastries->getItems()) . '<br>' . PHP_EOL;
//
//$invoices = null;
//try {
//    $invoices = ListGenerator::invoiceList($users, $pastries);
//} catch (Exception $e) {}

//for ($i = 0; $i < rand(4, 8); $i++) {
//    if (rand(0, 9) < 4) {
//        try {
//            $datasets['invoices']->add(EntityGenerator::invoice($user, $datasets['pastries']));
//        } catch (Exception $e) {
//            echo $e;
//        }
//    }
//}

//$page = new old_things_2024_04_23\pages_2024_04_23\CreditCardManagementPage($user);
//try {
//    $user = EntityGenerator::user();
//} catch (Exception $e) {
//    echo $e;
//}
//$user = unserialize($_SESSION['user']);
//$page = new userDashboard($user);

?>
<!---->
<!---->
<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <link rel="stylesheet" type="text/css" href="../../styles.css"/>-->
<!--    <title>-->
<!--        --><?php //echo $pageTitle; ?>
<!--    </title>-->
<!--</head>-->
<!--<body>-->
<!--<header>-->
<!--</header>-->
<!--    --><?php //echo '<h1>' . $pageTitle . '</h1>'; ?>
<!--<main>-->
<!--    <div class="dashboard">-->
<!--        <ul class="dashboard">-->
<!--            <li>-->
<!--                <a class="dashboard" id="contactDetailsPage" href="userContactDetailsPage.php">Manage Your Phone and Mailing Addresses</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a class="dashboard" id="contactDetailsPage" href="userSecuritySettingsPage.php">Manage Email address and password</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a class="dashboard" id="creditCardsPage" href="../../renders/getCreditCardsPage.php">Your Credit Cards</a>-->
<!--<!--                <a class="dashboard" id="creditCardsPage" href="creditCardPage.php">Your Credit Cards</a>-->-->
<!--            </li>-->
<!--            <li>-->
<!--                <a class="dashboard" id="wishListPage" href="wishListPage.php">Your Wish List</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a class="dashboard" id="ordersPage" href="ordersPage.php">Your Orders</a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
<!--    --><?php
////        echo '<p>' . $page->getUser()->getEmail() . '<br>';
////        echo $page->getUser()->getPostalAddress() . '<br>';
////        echo $page->getUser()->getPhone() . '<br>';
////        echo $page->getUser()->getCreditCards()->toTable() . '</p>';
////
////        echo ''
////        echo '<div><p><a href="creditCardPage.php">Your Credit Cards</a></p></div>';
////
////        foreach($page->getUser()->getShippingAddresses()->getItems() as $address) {
////            echo 'address:' . $address . '<br>' . PHP_EOL;
////        }
////        echo '<p><h2>Your Orders</h2>' . $userInvoices->toTable() . '</p>';
////        echo '<p><h2>Your Reviews</h2>' . $userReviews->toTable() . '</p>';
//    ?>
<!---->
<!--</main>-->
<!--<footer>-->
<!--</footer>-->
<!--</body>-->
<!--</html>-->