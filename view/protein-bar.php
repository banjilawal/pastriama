<?php
    namespace Shop\View;
    use Shop\Model\Bag\{CreditCardBag, ReviewBag};
    use Shop\Database\{ProteinBarQuery, CustomerQuery};
    use Shop\Model\{Customer, CreditCard, ProteinBar, OrderItem};

    require_once ('../bootstrap.php');
    require_once(MODEL_PATH . DIRECTORY_SEPARATOR . 'customerView.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'orderItem.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'creditCard.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'proteinBar.php');

    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'customerQuery.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'proteinBarQuery.php');

    if(session_id() == '') {
        session_start();
    }
    echo 'Customer Session<p>' . print_r($_SESSION['customer']) . '</p>';
    $customer = unserialize($_SESSION['customer']);
    $cards = $customer->credit_cards();

    echo $customer->get_firstname() . '\'s credit cards<br>' . $cards;

    echo $customer . '<br>';

    $id = $_COOKIE['proteinBarID']; 
    $proteinBar = \Shop\Database\ProteinBarQuery::find($id);
    $reviews = $proteinBar->reviews();

    $_SESSION['proteinBar'] = serialize($proteinBar->to_parent());
    echo 'ProteinBar Session<p>' . $_SESSION['proteinBar'] . '</p>';

    $title = $proteinBar->get_name() . ', ' . $proteinBar->get_grams() . ' grams ' . $proteinBar->get_price();
?>


<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>   
<header>
    <?php echo '<h1>' . $title . '</h1>'; ?>
</header>

<main>
    <div>
        <form id="order-form" name="order-form" method="POST" action="../form/current-shopping-cart.php">
            <fieldset><!--<legend>Add to Cart</legend>-->
                <!--<h3>Number of Bars (10 Maximum)</h3>-->
                <p>
                <label for="quantity">Quantity to Order</label><br>
                <input type="number" id="quantity" name="quantity" min="1" max="10" value="1">
                </p>
                <input id="submit" name="submit" type="submit" value="Add to Cart">
            </fieldset>
        </form>
    </div>

    <?php 
        echo '<p>' . $proteinBar->to_table() . '</p>';
    ?>
    
    <div>
    <h3>Would You Like to Add a Review</h3>
    <p></p>
        <form id="submit-rating-form" name="submit-rating-form" method="get" action="../control/process-rating.php">
            <table>
                <tr>
                    <td>
                        <p>
                            <label for="stars">How Many Stars?</label><br>
                            <select id="stars" name="stars" required="true" form="rating">
                                <option value="">-- Pick Your Rating --</option>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                        </p>
                        <p>
                            <label for="comments">Comments</label><br>
                            <textarea id="comments" name="comments" rows="30" cols="100"></textarea>
                        </p>
                    </td>
                </tr>
            </table>
            <input type="submit" id="submit-rating" name="submit-rating" value="Submit Rating"></input>
        </form>
    </div>

    <?php
        echo '<h2>Reviews</h2>';
        echo '<p>' . $reviews->by_product_table() . '</p>';
    ?>
</main>
</body>
<html>