<?php declare(strict_types=1);
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'bootstrap.php';
//require_once 'WebPage.php';

use app\models\concretes\Product;
use app\models\concretes\Pastry;
use app\models\concretes\Review;
use app\models\singletons\Inventory;
use app\test\ListGenerator;

//class PastryPage extends WebPage {
//    private Pastry $pastry;
//
//    public function __construct (Pastry $pastry) {
//        parent::__construct($pastry->__toString());
//        $this->pastry = $pastry;
//    }
//
//    public function getPastry (): Pastry {
//        return $this->pastry;
//    }
//} // end class PastryPage
//$lists = null;
//try {
//    $lists = ListGenerator::lists(30, 60);
//} catch (Exception $e) {
//    echo $e;
//}
//echo print_r($_SESSION['inventory']);
//$inventory = unserialize($_SESSION['inventory']);
//$inventoryItem = $inventory->getInventory()->searchById((int) $_COOKIE['inventoryItemId']);
$user = unserialize($_SESSION['user']);
$inventoryItem = unserialize($_SESSION['products'])->searchById((int) $_COOKIE['productId']);
//$reviews = unserialize($_SESSION['reviewsCatalog']); //)->filterByPastry($inventoryItem->getPastry());
//echo print_r($reviews->getItems());

$title = $inventoryItem->getPastry()->getName() . ' price:' . $inventoryItem->getPastry()->getName();
echo $inventoryItem;
//echo $inventory;
//print_r($_SESSION['inventory']->get);
//echo nl2br(print_r($_COOKIE) . ' ' . PHP_EOL);
//$pastry = $lists['pastries']->getItems()[array_rand($lists['pastries']->getItems())];
//$inventory = unserialize($_SESSION['inventory']);
//$inventoryItem = $inventory->getInventory()->searchById((int) $_COOKIE['inventoryItemId']);
//$title = $inventoryItem->getPastry->getName() . ' price:' . $inventoryItem->getPastry()->getName();
//$pastry = $lists['pastries']->getItems()[];
//$_SESSION['pastry'] = serialize($pastry);
//$reviews = $lists['reviews'];
//$page = new PastryPage($pastry);

//
//$pastries = null;
//try {
//    $pastries = ListGenerator::pastryList(40);
//} catch (Exception $e) {
//    echo $e;
//}
//
//$users = null;
//try {
//    $users = ListGenerator::userList(15);
//} catch (Exception $e) {
//    echo $e;
//}
//echo 'total users:' . count($users->getItems()) . '<br>' . PHP_EOL;
//
//$pastry = $pastries->getItems()[(array_rand($pastries->getItems()))];
//$reviews = new ReviewList();
//foreach ($users->getItems() as $user) {
//    if (rand(1, 4) < 3) {
//        echo '   Adding a review by ' . $user->getFirstname() . '<br>' . PHP_EOL;
//        try {
//            $reviews->add(EntityGenerator::review($user, $pastry));
//        } catch (Exception $e) {
//            echo $e;
//        }
//        echo count($reviews->getItems()) . ' reviews';
//    }
//}

//$page = new PastryPage($pastry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles.css"/>
    <title>
        <?php echo $title; ?>
    </title>
</head>
<body>
<header>
</header>
<main>
    <?php
    //        echo unserialize($_SESSION['user']) . '<br>' . PHP_EOL;
    //        echo print_r(unserialize($_SESSION['datasets'])) . '<br>' . PHP_EOL;
    //        echo $page->getPastry()->toTable(240, 260);
        echo '<div>' . $inventoryItem->getPastry()->toTable() . '</div>';
        echo '<div><emph><p>Average Rating ' . 10 . ' Stars!!</p></emph></div>';
        if ($inventoryItem->getQuantity() <= 15) {
            echo '<div>Only ' . $inventoryItem->getQuantity() . ' is left in stock. Order now</div>';
        }
        if (isset($_SESSION['reviewThankYouMessage'])) {
            echo '<div class="messageArea"><h3>' . $_SESSION['reviewThankYouMessage'] . '</h3></div>';
            unset($_SESSION['reviewThankYouMessage']);
        }
    ?>
    <div>
        <h2>Buying Options</h2>
        <div class="form">
            <form
                name="addItemToCartForm"
                id="addItemToCartForm"
                method="post"
                action="processAddToCartForm.php"
            >
                <fieldset>
                    <legend>Add to Your Cart</legend>
                    <div class="formElement"><p> <?php echo Product::quantitySelector(); ?> </p></div>
                    <p><input type="submit" name="addToCart" id="addToCart" value="Add to Cart"></p>
                </fieldset>
            </form>
        </div>
        <div class="form">
            <h2>Would You Like to Add a Review?</h2>
            <form id="ratingForm" name="ratingForm" method="post" action="processReviewForm.php">
                <fieldset>
                    <legend>Write a Review></legend>
                    <div class="formElement"><p> <?php echo Review::ratingSelector(); ?></p></div>
                    <div class="formElement">
                        <p>
                            <label for="reviewTitle">Title</label>
                            <input type="text" id="reviewTitle" name="reviewTitle" size="50" required>
                        </p>
                    </div>
                    <div class="formElement">
                        <p>
                            <label for="comment">Comment</label><br>
                            <textarea id="comment" name="comment" cols="100">...</textarea>
                        </p>
                    </div>
                    <input type="submit" id="submitRating" name="submitRating" value="Add Your Rating">
                </fieldset>
            </form>
        </div>
        <div class="popUp">
            <form class="popUp" id="oneClickBuyForm" name="oneClickBuyForm" method="post" action="processOneClickBuyForm.php">
                <fieldset>
                    <legend>Buy with One Click</legend>
                    <?php
                        echo '<div class="formElement"><p>' . $user->getCreditCards()->creditCardSelector()
                            . '</p></div>';
                        echo '<div class="formElement"><p>' . $user->getPostalAddresses()->shiptToSelector()
                            . '</p></div>';
                    ?>
                    <div class="formElement"><p></p></div>
                    <div class="formElement">
                        <input type="submit" id="oneClickBuyButton" value="Buy with One-Click">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div>
        <h2>Reviews</h2>
        <?php
            echo $reviews->toTable();
        //            $endDate = new DateTime(); //DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
//            $startDate = date_sub($endDate, new DateInterval('P10Y'));
//            $catalog = ReviewCatalog::getCatalog();
//            echo $catalog::pastrySearch($pastry, $startDate, $endDate)->toTable
        ?>
    </div>
</main>
<footer>
</footer>
</body>
</html>