<?php declare(strict_types=1);

require_once 'WebPage.php';

use app\models\lists\Orders;
use app\test\ListGenerator;

class InvoiceListPage extends WebPage {
    private Orders $invoiceList;

    public function __construct (Orders $orderList, string $title) {
        parent::__construct($title);
        $this->invoiceList = $orderList;
    }

    public function getInvoiceList (): Orders {
        return $this->invoiceList;
    }
}

$pastries = null;
try {
    $pastries = ListGenerator::pastryList(30);
} catch (Exception $e) {
}
echo 'Number of pastries:' . count($pastries->getItems()) . '<br>' . PHP_EOL;

$users = null;
try {
    $users = ListGenerator::userList(15);
} catch (Exception $e) {
}
echo 'Number of users:' . count($users->getItems()) . '<br>' . PHP_EOL;

$invoices = null;
try {
    $invoices = ListGenerator::Orders($users, $pastries);
} catch (Exception $e) {}

$page = new InvoiceListPage($invoices, 'Test Invoices');
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
<main>
    <?php
    echo $page->getInvoiceList()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>