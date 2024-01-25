<?php declare(strict_types=1);

namespace app\webpages\store\item;


use app\models\concretes\Pastry;
use app\models\singletons\ReviewCatalog;
use DateInterval;
use DateTime;

require_once '..\..\..\..\vendor\autoload.php'; // '..\..\..\vendor\autoload.php';

echo PHP_EOL . 'root:' . $_SERVER['DOCUMENT_ROOT'] . PHP_EOL;

$pastry = new Pastry(1,
    'Glazed Ginger-Almond Donut',
    'We have a fresh take of the glazed donut with our barrel aged ginger extract sourced locally 
        with hints of almond that does not overwhelm the honey.',
    'donut.jpg', 2.99);
$title = '<title>' . $pastry->getName() . '</title>';

echo PHP_EOL . 'root:' . (__DIR__) . PHP_EOL; //print_r($_SERVER['DOCUMENT_ROOT']) . PHP_EOL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php echo $title; ?>
</head>
<body>
<header>
</header>
<main>
    <div>
            <table>
                <thead></thead>
                <tbody>
                <tr>
                    <td>
                        <?php echo  $pastry->getImgTag(60, 40); ?>
                    </td>
                    <td> <?php echo '<p>' . $pastry->getName() . '</p><p>' . $pastry->getDescription() ?> </td>
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
                            <select id="rating" name="rating" required="true">
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
            $endDate = new DateTime(); //DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
            $startDate = date_sub($endDate, new DateInterval('P10Y'));
            $catalog = ReviewCatalog::getCatalog();
            echo $catalog::pastrySearch($pastry, $startDate, $endDate)->toTable();
        ?>
    </div>
</main>
<footer>
</footer>
</body>
</html>