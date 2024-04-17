<?php declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'WebPage.php';

use app\models\concretes\User;
use app\test\EntityGenerator;
use app\test\ListGenerator;


class CreditCardManagementPage extends WebPage {
    private User $user;

    public function __construct (User $user) {
        parent::__construct('Hello ' . $user->getFirstname());
        $this->user = $user;
    }

    public function getUser (): User {
        return $this->user;
    }
}

$datasets = null;
try {
    $datasets = ListGenerator::lists();
} catch (Exception $e) {
    echo $e . '<br>' . PHP_EOL;
}
$user = $datasets['users']->getItems()[array_rand($datasets['users']->getItems())];

//$users = null;
//try {
//    $users = ListGenerator::userList(15);
//} catch (Exception $e) {
//}
//$user = $users->searchById(array_rand($users->getItems()));

//$pastries = null;
//try {
//    $pastries = ListGenerator::pastryList(40);
//} catch (Exception $e) {
//}
//echo 'Number of pastries:' . count($pastries->getItems()) . '<br>' . PHP_EOL;
//
//$invoices = null;
//try {
//    $invoices = ListGenerator::invoiceList($users, $pastries);
//} catch (Exception $e) {}

for ($i = 0; $i < rand(4, 8); $i++) {
    if (rand(0, 9) < 4) {
        try {
            $datasets['invoices']->add(EntityGenerator::order($user, $datasets['pastries']));
        } catch (Exception $e) {
            echo $e;
        }
    }
}

$page = new CreditCardManagementPage($user);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo $page->getTitle(); ?>
    </title>
</head>
<body>
<header>
</header>
    <?php echo '<h1>' . $page->getTitle() . '</h1>'; ?>
<main>
    <?php
        echo '<p>' . $page->getUser()->getEmailAddress() . '<br>';
        echo $page->getUser()->getPostalAddress() . '<br>';
        echo $page->getUser()->getPhone() . '<br>';
        echo $page->getUser()->getCreditCards()->toTable() . '</p>';
        try {
            echo '<p><h2>Your Orders</h2>' . $datasets['invoices']->filterByUser($user)->toTable() . '</p>';
        } catch (Exception $e) {
            echo $e;
        }

        try {
            echo '<p><h2>Your Reviews</h2>' . $datasets['reviews']->filterByUser($user)->toTable() . '</p>';
        } catch (Exception $e) {
            echo $e;
        }
        echo '<p> <h2>All Invoices</h2>' . $datasets['invoices']->toTable() . '</p>';

        echo '<p> <h2>All Reviews</h2>' . $datasets['reviews']->toTable() . '</p>';
    ?>
</main>
<footer>
</footer>
</body>
</html>