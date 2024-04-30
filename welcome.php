<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}
else {
    session_start();
}

use app\models\catalogs\Inventory;
use app\models\catalogs\OrdersCatalog;
use app\models\catalogs\ReviewsCatalog;
use app\models\catalogs\UsersCatalog;
use app\test\ListGenerator;
require_once 'bootstrap.php';

//$datasets = null;
$pastries = null;
$products = null;
$users = null;
$reviews = null;
try {
    $pastries = ListGenerator::pastries(10);
    $products = ListGenerator::products($pastries);
    $users = ListGenerator::users(4);
    $reviews = ListGenerator::reviews($users, $pastries);
//    $datasets = ListGenerator::lists(4, 10);
} catch (Exception $e) {
    echo $e . '<br>' . PHP_EOL;
}

//echo println('reviews count:' . count($reviews->getList()));
//echo print_r($datasets->getList());

//$users = $datasets['users'];
//$pastries = $datasets['pastries'];
//$products = $datasets['products'];
//$orders = $datasets['orders'];
//$reviews = $datasets['reviews'];

$_SESSION['users'] = serialize($users);
$_SESSION['products'] = serialize($products);
//$_SESSION['orders'] = serialize($orders);
$_SESSION['reviews'] = serialize($reviews);

$reviewsCatalog = ReviewsCatalog::getInstance();
try {
    foreach ($reviews as $review) {
        $reviewsCatalog->getReviews()->addReview($review);
    }

} catch (Exception $e) {
}
//echo $reviewsCatalog->getReviews();
$_SESSION['reviewsCatalog'] = serialize('reviewsCatalog');
//echo println('reviews' . PHP_EOL . print_r($_SESSION['reviews']));

//
//$user = $users->getItems()[array_rand($users->getItems())];
//$_SESSION['user'] = serialize($user);
//echo 'unserial ' . unserialize($_SESSION['user']);
//
//if (is_null($users->searchByEmail($user->getEmailAddress()))) {
//    echo nl2br(PHP_EOL . 'Could not find user by email' . PHP_EOL);
//}
//else {
//    echo nl2br(PHP_EOL . 'Hello ' . $user->printName() . PHP_EOL);
//}
//echo $user;
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
            <form name="loginForm" id="loginForm" action="old_things_2024_04_23/pages_2024_04_23/processLoginForm.php" method="post">
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
      echo $products->toTable();
    ?>

    <script>
        function rowClickHandler (id) {
           let cookie = document.cookie = "productId=" + id + ""; // + "; max-age=5";
            alert(cookie);
            location.href = "renders/getProductPage.php";
        }
    </script>
</main>
<footer>
</footer>
</body>
</html>