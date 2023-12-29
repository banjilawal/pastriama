<?php

use global\IdGenerator;
use models\concretes\Pastry;
use models\concretes\Phone;
use models\factories\Factory;

//require_once('bootstrap.php');
//require_once('global\IdGenerator.php');
//require_once('models\concretes\Pastry.php');
//require_once('models\concretes\Phone.php');
require_once('vendor\autoload.php');

$page_title = 'Welcome to Pastriama';
$pastryA = null;
$pastryB = null;

//$phone = new Phone('204', '501', '3400');

try {
    $pastryA = new Pastry(IdGenerator::nextPastryId(), 'brioche', 'A classic french baked thing', 'brioche.jpg', 2.99);
    $pastryB = new Pastry(IdGenerator::nextPastryId(), 'croissant', '', 'croissant.jp', 4.99);
} catch (Exception $e) {
    echo $e;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
</head>
<body>
    <?php
        echo '<h2>' . $pastryA . '</h2>';
        echo $pastryA->toTable() . '<p></p>';
        
        echo '<h2>' . $pastryB . '</h2>';
        echo $pastryB->toTable();
//        echo '<p>' . $phone->toTable() . '</p>';
    ?>
</body>
</html>