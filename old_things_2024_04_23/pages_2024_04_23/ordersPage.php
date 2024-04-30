<?php declare(strict_types=1);
if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$user = unserialize($_SESSION['user']);
echo print_r($_SESSION['orders']);
$orders = unserialize($_SESSION['orders'])->filterByUser($user);
$pageTitle = 'Manage Your Orders ' . $user->printName();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../styles.css"/>
    <title>
        <?php echo $pageTitle; ?>
    </title>
</head>
<body>
<header>
</header>
<?php echo '<h1>' . $pageTitle . '</h1>'; ?>
<main>
    <div>
        <h2>The Orders</h2>
        <?php
            echo $orders->toTable(); //$user->getOrders(DateTime::createFromFormat('Y-m-d', '2020-01-01'), new DateTime())->toTable();
        ?>
    </div>
</main>
<footer>
</footer>
</body>
</html>