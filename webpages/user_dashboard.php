<?php declare(strict_types=1);

namespace webpages;

require_once '..\bootstrap.php';
//require_once '..\..\..\vendor\autoload.php';

//session_start();
if(session_id() == '') {
    session_start();
}

//$firstname = 'john';
//$lastname = 'madeira';
//$phone = new Phone('865', '309', '2020');
//$pastry = new Pastry(1, 'donut', 'a classic', 'donut.jpg', 1.99);
//$email = new EmailAddress(($firstname . '.' . $lastname), new Domain('wargame', 'com'));
//$postalAddress = new PostalAddress('2020 Clearview Ave', 'MAnzikert', new State('IA'), new Zipcode('12345') );
//$creditCard = null;
//try {
//    $creditCard = new CreditCard(1, '0123-4567-8910-9870', new DateTime('2027-06-01'), '206');
//} catch (Exception $e) { }
//echo 'phone' . $phone . '<br>' . PHP_EOL;
//echo 'pastry:' . $pastry . '<br>' . PHP_EOL;
//echo 'email:' . $email . '<br>' . PHP_EOL;
//echo 'mailing address:' . $postalAddress . '<br>' . PHP_EOL;
//echo 'credit card:' . $creditCard . '<br>' .  PHP_EOL;
//
//$user2 = new User(
//    1, //$serialNumber->nextUserId(),
//    $firstname,
//    $lastname,
//    new DateTime('1978-06-25'),
//    $phone,
//    $email,
//    'p',
//    $postalAddress
//);
//
//echo $user2;


//if(isset($_SESSION['username'])) {
//    echo 'session is lost' . PHP_EOL;
//    echo "Your session is running " . $_SESSION['user'];
//} else {
//    echo 'Your session is lost.';
//}

//use app\models\concretes\User;

$firstname= $_SESSION['firstname'];
$serial = $_SESSION['user'];
$user = unserialize($serial);

//echo 'IN USER_HOME:<br>' . PHP_EOL . '<br>------------------<br>' . PHP_EOL . $firstname;
echo 'user:' . $user->__toString();



//namespace app\webpages\user;





//echo 'session_id:' . session_id();
//
//var_dump($_SESSION['user']);
//
//var_dump($_POST);
//$user = unserialize($_SESSION['user']);

//require_once '..\..\..\test_index.php';
//require_once('..\..\..\test_index.php');



//echo 'Project Hone:' .  $_SERVER['DOCUMENT_ROOT'];
//$user = unserialize($_SESSION['user']);

//echo $user;


//$pages = new PageLinkList();

//$currentDirectory = __DIR__;
//$destination = __DIR__ . DIRECTORY_SEPARATOR . 'user_orders.php';
//if (file_exists($destination)) {
//    echo $destination;
//} else {
//    echo "HTML file not found: $$destination";
//}
//

//$pages->add(new PageLink(1, 'user_orders.php', 'Your Orders'));
//$pages->add(new PageLink(2, 'user_wishlist.php', 'Wishlist'));
//$pages->add(new PageLink(3, 'user_contact_info.php', 'Address and Phone'));
//$pages->add(new PageLink(4, 'user_security.php', 'Email and Security'));
//$pages->add(new PageLink(5, 'user_cards.php', 'Payment Methods'));
//$pages->add(new PageLink(6,'user_orders.php', 'Your Orders'));

//    $user = unserialize($_SESSION['user']);
$title = '<title>Welcome to Your Dashboard ' . $user->getName() . '</title>';
$heading = '<h1>Welcome to Your Dashboard ' . $user->getName() . '</h1>'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php echo $title?>
    <!--    <title>Welcome to User Home</title>-->
</head>
<body>
<header>
    <div class="grid-item">Logo</div>
    <div class="grid-item">Search</div>
    <div class="grid-item">Hi User</div>
    <div class="grid-item">Shopping Cart</div>
    <div class="grid-item">Help</div>
</header>
<nav>
    <div class="nav-item">
        <input type="search" id="search-bar" name="search-bar"/>
        <label for="search-bar">Search</label>
    </div>
    <div class="nav-item">
        <a id="use-dashboard" name="user-dashboard" href="user_dashboard.php">Your Dashboard</a>
    </div>
    <div class="nav-item">
        <a id="wishlist" name="wishlist" href="user_wishlist.php">Wishlist</a>
    </div>
    <div class="nav-item">
        <a id="orders" name="orders" href="user_orders.php">Orders</a>
    </div>
    <div class="nav-item">
        <a id="shopping-cart" name="shopping-cart" href="user_shopping_cart.php">Shopping Cart</a>
    </div>
</nav>
<main>
    <?php
    echo $heading;
    echo $pages->toList();
    ?>
</main>
<footer>
</footer>
</body>
</html>