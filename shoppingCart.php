<?php declare(strict_types=1);
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'bootstrap.php';

$user = unserialize($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles.css"/>
    <title>
        <?php echo $user->printName() . '\'s Shopping Cart'; ?>
    </title>
</head>
<body>
<header>
</header>
<main>
    <?php
        echo '<h1>Here is Your Shopping Cart ' . $user->printName() . '</h1>'
            . $user->getShoppingCart()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>