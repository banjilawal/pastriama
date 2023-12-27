<?php
    namespace View;

    use \Database\CustomerQuery;

    require_once ('../bootstrap.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'customerQuery.php');
    /*
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'order.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'customerView.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'orderItem.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'orderItemBag.php');
*/
    if(session_id() == '') {
        session_start();
    }

    echo '<p>' . $_SERVER['HTTP_REFERER'] . '</p>';

    $customer = unserialize(($_SESSION['customer']));
    echo $customer;

    $orders = $customer->orders();

    $title = 'Your Orders ' . $customer->get_firstname();
?>


<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <?php echo '<title>' . $title .  '</title>'; ?>
</head>

<body>   
<header>
    <?php echo '<h1>' . $title .  '</h1>'; ?>
</header>

<main>
    <?php
        echo $orders->to_table();
    ?>

    <script>
        function send_order (row) {
            data = row.childNodes[0];
            cell = row.cells[0];
            //alert(cell.innerHTML);
            cookie = document.cookie = "orderID=" + cell.innerHTML + ""; // + "; max-age=5";

            location.href = "customer-order-details.php";
        }
    </script>
</main>
</body>
<html>