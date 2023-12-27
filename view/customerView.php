<?php
    namespace View;
    #use \Shop\Model\Customer;
use DateTime;
use \Shop\Database\CustomerQuery;

    require_once ('../bootstrap.php');
    #require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'customerView.php');

    if(session_id() == '') {
        session_start();
    }


    if (isset($_SESSION['customer']) == false) {
        $id = $_COOKIE['customerID']; 
        $query = new CustomerQuery();   
        $customer = $query->find($id);
        $_SESSION['customer'] = serialize($customer);
    }
    else {
        $customer = unserialize($_SESSION['customer']);
    }

?>


<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>   
<header>
    <?php echo '<h1>Hello ' . $customer->getFirstname() . ' ' .  $customer->getLastname() . '</h1>'; ?>
</header>

<nav>
    <ul>
        <li><button type="button" onclick="get_customer_items()">Your Previous Orders</button></li>
        <li><button type="button" onclick="change_address()">Update Your Addresss</button></li>
        <li><button type="button" onclick="new_card()">Add Credit Card</button></li>
        <li><button>Change Your Password</button></li>
    </ul>
</nav>
<main>
    <?php
        $startDate = DateTime::createFromFormat('U', time());
        $endDate = $startDate->modify('- 12 months');
        echo '<p>' . $customer->toTable() . '</p>';

        echo '<h2>Credit Cards</h2>';
        echo $customer->creditCardsTable() . '<br>';

        echo '<h2>Orders</h2><br>';
        echo $customer->ordersToTable($startDate, $endDate) . '<br>';
    
        echo '<h2>Wish List</h2><br>';
        echo $customer->wishListToTable($startDate, $endDate) . '<br>';
    ?>

    <script>
        function new_card() {
            location.href = "../view/new-credit-card-form.php";
        }

        function change_address() {
            location.href = "address-update-form.php";
        }

        function get_customer_items() {
            location.href = "customer-orders.php";
        }

        function send_order(row) {
            data = row.childNodes[0];
            cell = row.cells[0];
            cookie = document.cookie = "orderID=" + cell.innerHTML; // + "; max-age=5";
            location.href = "order.php";
        }
    </script>
</main>
</body>
<html>