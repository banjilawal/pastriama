<?php declare(strict_types=1);

use app\templates\Dashboard;
use app\templates\Script;

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'data_loader.php';


//echo print_r($_SESSION);



$inventory = unserialize($_SESSION['inventory']);

$inventoryItem = unserialize($_SESSION['inventory'])->searchById(((int) $_COOKIE['productId']));
$reviews = unserialize($_SESSION['reviews'])->filterByProduct($inventoryItem->getProduct());


//echo $inventoryItem;

$title = $inventoryItem->getProduct()->__toString();

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
    try {
        echo Dashboard::product($inventoryItem->getProduct(), $reviews);
    } catch (Exception $e) { echo $e; }
    ?>
<!--    --><?php
//    //        echo unserialize($_SESSION['user']) . '<br>' . PHP_EOL;
//    //        echo print_r(unserialize($_SESSION['datasets'])) . '<br>' . PHP_EOL;
//    //        echo $page->getPastry()->toTable(240, 260);
//        echo '<div>' . $inventoryItem->getPastry()->toTable() . '</div>';
//        echo '<div><emph><p>Average Rating ' . 10 . ' Stars!!</p></emph></div>';
//        if ($inventoryItem->getQuantity() <= 15) {
//            echo '<div>Only ' . $inventoryItem->getQuantity() . ' is left in stock. Order now</div>';
//        }
//        if (isset($_SESSION['reviewThankYouMessage'])) {
//            echo '<div class="messageArea"><h3>' . $_SESSION['reviewThankYouMessage'] . '</h3></div>';
//            unset($_SESSION['reviewThankYouMessage']);
//        }
//    ?>
<!--    <div>-->
<!--        <h2>Buying Options</h2>-->
<!--        <div class="form">-->
<!--            <form-->
<!--                name="addItemToCartForm"-->
<!--                id="addItemToCartForm"-->
<!--                method="post"-->
<!--                action="processAddToCartForm.php"-->
<!--            >-->
<!--                <fieldset>-->
<!--                    <legend>Add to Your Cart</legend>-->
<!--                    <div class="formElement"><p> --><?php //echo InventoryItem::quantitySelector(); ?><!-- </p></div>-->
<!--                    <p><input type="submit" name="addToCart" id="addToCart" value="Add to Cart"></p>-->
<!--                </fieldset>-->
<!--            </form>-->
<!--        </div>-->
<!--        <div class="form">-->
<!--            <h2>Would You Like to Add a Review?</h2>-->
<!--            <form id="ratingForm" name="ratingForm" method="post" action="processReviewForm.php">-->
<!--                <fieldset>-->
<!--                    <legend>Write a Review></legend>-->
<!--                    <div class="formElement"><p> --><?php //echo review::ratingSelector(); ?><!--</p></div>-->
<!--                    <div class="formElement">-->
<!--                        <p>-->
<!--                            <label for="reviewTitle">Title</label>-->
<!--                            <input type="text" id="reviewTitle" name="reviewTitle" size="50" required>-->
<!--                        </p>-->
<!--                    </div>-->
<!--                    <div class="formElement">-->
<!--                        <p>-->
<!--                            <label for="comment">Comment</label><br>-->
<!--                            <textarea id="comment" name="comment" cols="100">...</textarea>-->
<!--                        </p>-->
<!--                    </div>-->
<!--                    <input type="submit" id="submitRating" name="submitRating" value="Add Your Rating">-->
<!--                </fieldset>-->
<!--            </form>-->
<!--        </div>-->
<!--        <div class="popUp">-->
<!--            <form class="popUp" id="oneClickBuyForm" name="oneClickBuyForm" method="post" action="processOneClickBuyForm.php">-->
<!--                <fieldset>-->
<!--                    <legend>Buy with One Click</legend>-->
<!--                    --><?php
//                        echo '<div class="formElement"><p>' . $user->getCreditCards()->creditCardSelector()
//                            . '</p></div>';
//                        echo '<div class="formElement"><p>' . $user->getPostalAddresses()->shiptToSelector()
//                            . '</p></div>';
//                    ?>
<!--                    <div class="formElement"><p></p></div>-->
<!--                    <div class="formElement">-->
<!--                        <input type="submit" id="oneClickBuyButton" value="Buy with One-Click">-->
<!--                    </div>-->
<!--                </fieldset>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div>-->
<!--        <h2>Reviews</h2>-->
<!--        --><?php
//            echo $reviews->toTable();
        //            $endDate = new DateTime(); //DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
//            $startDate = date_sub($endDate, new DateInterval('P10Y'));
//            $catalog = ReviewCatalog::getCatalog();
//            echo $catalog::pastrySearch($pastry, $startDate, $endDate)->toTable
//        ?>
<!--    </div>-->
</main>
<footer>
</footer>
</body>
</html>