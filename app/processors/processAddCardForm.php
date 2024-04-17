<?php declare(strict_types=1);
session_start();

use app\models\concretes\CreditCard;
use app\utils\SerialNumber;

require_once 'bootstrap.php';


$user = unserialize($_SESSION['user']);
$vendor = $_POST['vendor'];
$nameOnCard = $_POST['nameOnCard'];
$number = $_POST['number'];
$cvn = $_POST['cvn'];
$expirationMonth = $_POST['expirationMonth'];
$expirationYear = $_POST['expirationYear'];

$card = null;
try {
    $card = new CreditCard(
        SerialNumber::nextCreditCardId(),
        $vendor,
        $nameOnCard,
        $number,
        DateTime::createFromFormat(
            'Y-m-d',
            $expirationYear . '-' . $expirationMonth
        ),
        $cvn
    );
} catch (Exception $e) {
    echo $e;
}
$user->getCreditCards()->add($card);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../styles.css"/>
    <title>
        processing card
    </title>
</head>
<body>
<header>
</header>
    <h1>processing card</h1>
<main>
    <?php
        echo $card . '<br>' .PHP_EOL;
        echo $user->getCreditCards()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>