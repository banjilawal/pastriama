<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}
else {
    session_start();
}

use app\models\singletons\Inventory;
use app\models\singletons\OrdersCatalog;
use app\models\singletons\ReviewsCatalog;
use app\models\singletons\UsersCatalog;
use app\test\ListGenerator;
require_once 'bootstrap.php';


//$users = null;
//try {
//    $users = ListGenerator::userList(20);
//} catch (Exception $e) {
//    echo $e;
//}
//
//$pastries = null;
//try {
//    $pastries = ListGenerator::pastryList(20);
//} catch (Exception $e) {
//    echo $e;
//}
//echo print_r($pastries);

$datasets = null;
try {
    $datasets = ListGenerator::lists(4, 10);
} catch (Exception $e) {
    echo $e . '<br>' . PHP_EOL;
}
$users = $datasets['users'];
$inventory = $datasets['inventory'];
$ordersCatalog = $datasets['orders'];
$reviewsCatalog = $datasets['reviews'];

$_SESSION['users'] = serialize($users);
$_SESSION['inventory'] = serialize($inventory);
$_SESSION['ordersCatalog'] = serialize($ordersCatalog);
$_SESSION['reviewsCatalog'] = serialize($reviewsCatalog);

$user = $users->getItems()[array_rand($users->getItems())];
$_SESSION['user'] = serialize($user);
echo 'unserial ' . unserialize($_SESSION['user']);

if (is_null($users->searchByEmail($user->getEmailAddress()))) {
    echo nl2br(PHP_EOL . 'Could not find user by email' . PHP_EOL);
}
else {
    echo nl2br(PHP_EOL . 'Hello ' . $user->printName() . PHP_EOL);
}
//$inventory = Inventory::getInstance();
//foreach ($datasets['pastries']->getItems() as $pastry) {
//    try {
//        $inventory->addPastry($pastry);
//    } catch (Exception $e) {
//        echo $e;
//    }
//}
//$_SESSION['inventory'] = serialize($inventory);
//echo nl2br('the inventory has ' . $inventory->getInventory()->getNumberOfItems()
//    . ' items in ' . count(unserialize($_SESSION['inventory'])->getInventory()->getItems()) . ' products' . PHP_EOL);
//print_r($_SESSION['inventory']);
//
//$ordersCatalog = $datasets['orders'];
//$_SESSION['ordersCatalog'] = serialize($ordersCatalog);
//foreach ($datasets['orders']->getItems() as $order) {
//    try {
//        $ordersCatalog->add($order);
//    } catch (Exception $e) {
//        echo $e;
//    }
//}
//echo nl2br('there are ' . count($ordersCatalog->getOrders()->getItems()) . ' orders' . PHP_EOL);
//$_SESSION['ordersCatalog'] = serialize($ordersCatalog);
//
//$reviewsCatalog = ReviewsCatalog::getInstance();
//foreach ($datasets['reviews']->getItems() as $review) {
//    try {
//        $reviewsCatalog->add($review);
//    } catch (Exception $e) {
//        echo $e;
//    }
//}
//echo nl2br('there are ' . count($reviewsCatalog->getReviews()->getItems()) . ' reviews' . PHP_EOL);
//$_SESSION['reviewsCatalog'] = serialize($reviewsCatalog);
//
//$users = UsersCatalog::getInstance();
//foreach ($datasets['users']->getItems() as $user) {
//    try {
//        $users->add($user);
//    } catch (Exception $e) {
//        echo $e;
//    }
//}
//echo nl2br('there are ' . count($users->getUsers()->getItems()) . ' users' . PHP_EOL);
//$user = $users->randomUser();
//$_SESSION['users'] = serialize($users);
//$_SESSION['user'] = serialize($user);
//echo print_r($datasets['orders']);
//$inventory = Inventory::getInventory();
//try {
//    Inventory::getInventory()->addPastries($datasets['pastries']);
//} catch (Exception $e) {
//}

//$_SESSION['datasets'] = serialize($datasets);
//$_SESSION['pastries'] = serialize($datasets['pastries']);
////$_SESSION['users'] = serialize($datasets['users']);
//$_SESSION['orders'] = serialize($datasets['orders']);
//$_SESSION['reviews'] = serialize($datasets['reviews']);
//$user = $users->getUsers()->getItems()[array_rand($datasets['users']->getItems())];
//$userInvoices = $datasets['orders']->filterByUser($user);
//$userReviews = $datasets['reviews']->filterByUser($user);


//$_SESSION['pastries'] = serialize($pastries);

echo $user;
//$_SESSION['user'] = serialize($user);
//$_SESSION['userInvoices'] = serialize($userInvoices);
//$_SESSION['userReviews'] = serialize($userReviews);
//$page = new PastryListPage($datasets['pastries'], 'Welcome to Our Pastry Store');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css"/>
    <title>
        Welcome to Our Pastry Store
    </title>
</head>
<body>
<header>
    <nav>
        <div class="navigation">
            <ul>
                <li><a href="">Inventory Lnk Placeholder</a></li>
                <li><a href="">Your Orders Link Placeholder</a></li>
            </ul>
        </div>
        <div class="form">
            <form name="loginForm" id="loginForm" action="processLoginForm.php" method="post">
                <fieldset name="login" id="login">
                    <legend>Login to Your Account</legend>
                    <div>
                        <p>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email"  size="30" required>
                        </p>
                    </div>
                    <div class="formElement">
                        <p>
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" size="30" required>
                        </p>
                    </div>
                    <input type="submit" value="login">
                </fieldset>
            </form>
        </div>
        <div>
            <p>
                <button
                    type="button"
                    name="registrationButton"
                    id="registrationButton"
                    onclick="location.href='createAccountForm.php'">
                "I Don't Have an Account"
                <!--                (() => { alert('Button clicked'); })()">I Don't Have an Account-->
                </button>
            </p>
        </div>
    </nav>
</header>
<main>
    <h1>Our Pastries</h1>
    <?php
      echo $inventory->toTable();
    ?>

    <script>
        function send (id) {
           let cookie = document.cookie = "inventoryItemId=" + id + ""; // + "; max-age=5";
            alert(cookie);
           location.href = "inventoryItemPage.php";
        }
    </script>
</main>
<footer>
</footer>
</body>
</html>