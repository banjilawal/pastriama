<?php
    session_start();
    require_once ('../bootstrap.php');
    require_once (MODEL_PATH . '/order.php');
    require_once ('../db/order-queries.php');

    print_r($_COOKIE);
    $id = $_COOKIE['orderID']; 

    $order = order_query($id);
    $orderItemBag = order_details_query($order);
    #echo $orderItems->to_table();  

    $title = 'Order ' . $order->get_id() . ' Details';
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
        echo '<h2>Order</h2>';       
        echo $order->to_table() . '<br>';

        echo '<h2>Customer Information</h2>';
        echo $order->get_customer()->to_table() . '<br>';

        echo '<h3>Order Items</h3>';       
        echo $order->get_items()->to_table();
    ?>

<script>
        function send_order_item(row) {
            data = row.childNodes[0];
            cell = row.cells[0];
            cookie = document.cookie = "orderItemID=" + cell.innerHTML + "; max-age=5";

            location.href = "order-item.php";
        }
    </script>
</main>

</body>
<html>