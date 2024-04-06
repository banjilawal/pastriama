<?php declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'WebPage.php';

use app\models\concretes\Pastry;
use app\models\lists\ReviewList;
use app\test\EntityGenerator;
use app\test\ListGenerator;

class PastryPage extends WebPage {
    private Pastry $pastry;

    public function __construct (Pastry $pastry) {
        parent::__construct($pastry->__toString());
        $this->pastry = $pastry;
    }

    public function getPastry (): Pastry {
        return $this->pastry;
    }
} // end class PastryPage
$lists = null;
try {
    $lists = ListGenerator::lists(30, 60);
} catch (Exception $e) {
    echo $e;
}
$pastry = $lists['pastries']->getItems()[array_rand($lists['pastries']->getItems())];
$reviews = $lists['pastries']->getItems()[array_rand($lists['pastries']->getItems())];
$page = new PastryPage($pastry);

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

$page = new PastryPage($pastry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo $page->getTitle(); ?>
    </title>
</head>
<body>
<header>
</header>
<main>
    <?php
        echo $page->getPastry()->toTable(240, 260);
    ?>
    <div>
            <table>
                <thead></thead>
                <tbody>
                <tr>
                    <td>
                        <?php // echo  $pastry->getImgTag(60, 40); ?>
                    </td>
                    <td> <?php //echo '<p>' . $pastry->getName() . '</p><p>' . $pastry->getDescription() ;?> </td>
                    <td>
                        <form id="order-form" name="order-form" method="post" action="shoppingCart.php">
                        <fieldset>
                            <p>
                                <label for ="quantity">Quantity to Order</label><br>
                                <select id="quantity" name="quantity">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </p>
                            <p>
                                <input id="submit" name="submit" type="submit" value="Add to Cart">
                            </p>
                        </fieldset>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
            <div>
            </div>
    </div>
    <div>
        <h3>Would You Like to Add a Review?</h3>
        <form id="rating-form" name="rating-form" method="post" action="processRating.php">
            <table>
                <thead>
                    <th>
                        <td>Number of Stars</td>
                        <td>Comments</td>
                    </th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="rating">How Many Stars</label>
                            <select id="rating" name="rating" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>
                        <td>
                            <label for="comments">Comments</label>
                            <textarea id="comments" name="comments" row="30" cols="100"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" id="submit-rating" name="submit-rating" value="Add Your Rating"></input>
        </form>
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