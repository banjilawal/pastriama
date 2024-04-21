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

//$datasets = null;
$pastries = null;
$products = null;
$users = null;
try {
    $pastries = ListGenerator::pastries();
    $products = ListGenerator::products($pastries);
    $users = ListGenerator::users(4);
//    $datasets = ListGenerator::lists(4, 10);
} catch (Exception $e) {
    echo $e . '<br>' . PHP_EOL;
}
//echo print_r($datasets->getList());

//$users = $datasets['users'];
//$pastries = $datasets['pastries'];
//$products = $datasets['products'];
//$orders = $datasets['orders'];
//$reviews = $datasets['reviews'];

$_SESSION['users'] = serialize($users);
$_SESSION['products'] = serialize($products);
//$_SESSION['orders'] = serialize($orders);
//$_SESSION['reviews'] = serialize($reviews);
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