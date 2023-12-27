<?php
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
 #   setcookie(session_name(),'',0,'/');
 #   session_regenerate_id(true);
    require_once ('../bootstrap.php');
    #require_once ('../model/customerView.php');
    require_once ('../model/order.php');
    #require_once ('../model/orderItem.php');
    #require_once (MODEL_PATH . '/proteinBar.php');
    require_once ('../db/collection-queries.php');

    $orderBag = collect_orders(75);
 
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!--<script type="text/javascript" src="script.js"></script> --> 
    <!--<script type="text/php" src="script.php"></script> --> 
      <title>Orders</title>
</head>

<body>   
<header>
    <h1>Orders</h1>
</header>

<nav></nav>
<main>
    <?php  echo $orderBag->to_table(); ?>
    <script>
        function send_order(row) {
            data = row.childNodes[0];
            cell = row.cells[0];
            cookie = document.cookie = "orderID=" + cell.innerHTML + "; max-age=5";

            location.href = "order.php";
        }
    </script>
</main>
</body>
<html>