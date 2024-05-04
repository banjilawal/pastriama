<?php declare(strict_types=1);

use app\models\catalogs\Inventory;
use app\test\EntityGenerator;
use app\test\ListGenerator;

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}
else {
    session_start();
}

require_once 'bootstrap.php';

$product = null;
$user = null;
$review = null;
$order = null;
$products = null;
$users = null;
$reviews = null;
try {
    $product = EntityGenerator::product();
    $user = EntityGenerator::user();
    $review = EntityGenerator::review($user, $product);
    $order = EntityGenerator::order($user);
//    echo nl2br(
//            'product:' . $review->product->getName()
//            . 'reviewer:' . $review->getUser()->printName()
//            . 'title: ' . $review->getTitle()
//            . ' rating:' . $review->getRating()->name
//            . ' comment:' . $review->getComment()
//            . ' submitDate:' . $review->getSubmissionTime()->format(DATE_FORMAT) . PHP_EOL
//    );
//    if (is_null($review)) {echo 'null';} else { echo 'not null';}
    $products = ListGenerator::products(19);
    $users = ListGenerator::users(30);
    $reviews = ListGenerator::reviews($users, $products);
} catch (Exception $e) { echo $e; }

$inventory = Inventory::getInstance();
foreach ($products->getItems() as $item) {
    try {
        $inventory->add($item, rand(1, DEFAULT_RESTOCK_QUANTITY));
    } catch (Exception $e) { echo $e; }
}
echo println('number of products in inventory: ' . count($inventory->getItems()));
try {
    $users = ListGenerator::shoppingCarts($users);
} catch (Exception $e) { echo $e; }

foreach ($users->getLIst() as $id => $user) {
//    echo println($user->printName() . '\'s ' . $user->getCart());
    try {
        $order = EntityGenerator::order($user);
    } catch (Exception $e) { echo $e; }
    echo $order;
}


//echo nl2br('' . $products . PHP_EOL . $users . PHP_EOL . $reviews);
echo nl2br($product . PHP_EOL . $user . PHP_EOL. $review . PHP_EOL . $user->getCart() . PHP_EOL);



?>
<!---->
<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--        <link rel="stylesheet" href="styles.css"/>-->
<!--    <title>-->
<!--        Welcome to Our Pastry Store-->
<!--    </title>-->
<!--</head>-->
<!--<body>-->
<!--<header>-->
<!--    <nav>-->
<!--        <div class="navigation">-->
<!--            <ul>-->
<!--                <li><a href="">Inventory Lnk Placeholder</a></li>-->
<!--                <li><a href="">Your Orders Link Placeholder</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <div class="form">-->
<!--            <form name="loginForm" id="loginForm" action="old_things_2024_04_23/pages_2024_04_23/processLoginForm.php" method="post">-->
<!--                <fieldset name="login" id="login">-->
<!--                    <legend>Login to Your Account</legend>-->
<!--                    <div>-->
<!--                        <p>-->
<!--                            <label for="email">Email</label>-->
<!--                            <input type="email" name="email" id="email"  size="30" required>-->
<!--                        </p>-->
<!--                    </div>-->
<!--                    <div class="formElement">-->
<!--                        <p>-->
<!--                            <label for="password">Password</label>-->
<!--                            <input type="password" id="password" name="password" size="30" required>-->
<!--                        </p>-->
<!--                    </div>-->
<!--                    <input type="submit" value="login">-->
<!--                </fieldset>-->
<!--            </form>-->
<!--        </div>-->
<!--        <div>-->
<!--            <p>-->
<!--                <button-->
<!--                    type="button"-->
<!--                    name="registrationButton"-->
<!--                    id="registrationButton"-->
<!--                    onclick="location.href='createAccountForm.php'">-->
<!--                "I Don't Have an Account"-->
<!--                <!--                (() => { alert('Button clicked'); })()">I Don't Have an Account-->-->
<!--                </button>-->
<!--            </p>-->
<!--        </div>-->
<!--    </nav>-->
<!--</header>-->
<!--<main>-->
<!--    <h1>Our Pastries</h1>-->
<!--    --><?php
//      echo $products->toTable();
//    ?>
<!---->
<!--    <script>-->
<!--        function rowClickHandler (id) {-->
<!--           let cookie = document.cookie = "productId=" + id + ""; // + "; max-age=5";-->
<!--            alert(cookie);-->
<!--            location.href = "renders/getProductPage.php";-->
<!--        }-->
<!--    </script>-->
<!--</main>-->
<!--<footer>-->
<!--</footer>-->
<!--</body>-->
<!--</html>-->