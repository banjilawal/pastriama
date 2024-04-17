<?php declare(strict_types=1);
namespace app\oldpages;

require_once '..\..\bootstrap.php';

use app\models\singletons\ReviewsCatalog;
use app\test\OldPrimitiveGenerator;

class OldPastryPage {

}
const PASTRY_IMAGE_HEIGHT = 60;
const PASTRY_IMAGE_WIDTH = 40;

$generator = new OldPrimitiveGenerator();
$pastry = $generator->pastry();

$pageTitle = '<title>' . $pastry->getName() . '</title>';
$pageHeading = '<h1>' . $pastry->getName() . '</h1>';

$reviewsCatalog = ReviewsCatalog::getCatalog();
$reviews = $reviewsCatalog->filterByPastry($pastry);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php echo $pageTitle; ?>
</head>
<body>
<header>
</header>
    <?php echo $pageHeading; ?>
<main>
    <div id="pastry-table-div">
        <table>
            <thead>
            </thead>
            <tbody>
            <tr>
                <td id="pastry-image-cell">
                    <?php echo  $pastry->getImgTag(); ?>
                </td>
                <td id="pastry-description-cell">
                    <?php echo $pastry->getDescription() ;?> </td>
                <td id="pastry-order-form-cell">
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
        ?>
    </div>
</main>
<footer>
</footer>
</body>
</html>