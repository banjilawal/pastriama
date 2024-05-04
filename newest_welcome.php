<?php declare(strict_types=1);

use app\models\catalogs\Inventory;
use app\templates\HTMLSection;
use app\templates\HTMLForm;
use app\templates\HTMLList;
use app\templates\Script;
use app\test\EntityGenerator;
use app\test\ListGenerator;

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}
else {
    session_start();
}

require_once 'data_loader.php';

$users = unserialize($_SESSION['users']);
$inventory = unserialize($_SESSION['inventory']);
//print_r($inventory->getItems());
//print_r($users->getUsers()->getList());
//print_r($users->getUsers()->getList());
$user = $users->randomUser(); // . PHP_EOL);
echo nl2br(PHP_EOL . $user . PHP_EOL);
$title = 'Welcome to Our Pastry Store';
echo HTMLSection::head($title) . HTMLSection::navbar()
    . HTMLList::inventory($inventory) . Script::welcomePage() . HTMLSection::footer();


?>

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
<!---->
<!--<!--        <div class="form">-->-->
<!--<!--            <form name="loginForm" id="loginForm" action="old_things_2024_04_23/pages_2024_04_23/processLoginForm.php" method="post">-->-->
<!--<!--                <fieldset name="login" id="login">-->-->
<!--<!--                    <legend>Login to Your Account</legend>-->-->
<!--<!--                    <div>-->-->
<!--<!--                        <p>-->-->
<!--<!--                            <label for="email">Email</label>-->-->
<!--<!--                            <input type="email" name="email" id="email"  size="30" required>-->-->
<!--<!--                        </p>-->-->
<!--<!--                    </div>-->-->
<!--<!--                    <div class="formElement">-->-->
<!--<!--                        <p>-->-->
<!--<!--                            <label for="password">Password</label>-->-->
<!--<!--                            <input type="password" id="password" name="password" size="30" required>-->-->
<!--<!--                        </p>-->-->
<!--<!--                    </div>-->-->
<!--<!--                    <input type="submit" value="login">-->-->
<!--<!--                </fieldset>-->-->
<!--<!--            </form>-->-->
<!--<!--        </div>-->-->
<!--        <div>-->
<!--            --><?php
//            echo HTMLForm::loginForm();
//            ?>
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
//      echo HTMLList::inventory($inventory);
//    ?>
<!---->
<!--    <script>-->
<!--        function rowClickHandler (id) {-->
<!--           let cookie = document.cookie = "productId=" + id + ""; // + "; max-age=5";-->
<!--            alert(cookie);-->
<!--            location.href = "productPage.php";-->
<!--        }-->
<!--    </script>-->
<!--</main>-->
<!--<footer>-->
<!--</footer>-->
<!--</body>-->
<!--</html>-->