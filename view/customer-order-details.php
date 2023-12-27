<?php
    namespace Shop\View;
    
    use Shop\Database\{OrderQuery, CustomerQuery};

    require_once ('../bootstrap.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'customerQuery.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'orderQuery.php');

    if(session_id() == '') {
        session_start();
    }

    $order = null;

    $customer = unserialize($_SESSION['customer']);
    $order = OrderQuery::find($_COOKIE['orderID']);
    $order->get_items();
    

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
        echo $order->to_grandparent()->to_table();

        echo '<h2>Items in Order</h2>';       
        echo $order->to_table() . '<br>';
    ?>

</main>

</body>
<html>