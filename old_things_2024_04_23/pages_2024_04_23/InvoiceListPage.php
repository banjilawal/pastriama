<?php declare(strict_types=1);

namespace old_things_2024_04_23\pages_2024_04_23;
require_once 'WebPage.php';

use app\models\collections\Orders;
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
    $pastries = ListGenerator::pastries(30);
} catch (Exception $e) {
}
echo 'Number of pastries:' . count($pastries->getList()) . '<br>' . PHP_EOL;

$users = null;
try {
    $users = ListGenerator::users(15);
} catch (Exception $e) {
}
echo 'Number of users:' . count($users->getList()) . '<br>' . PHP_EOL;

$invoices = null;
try {
    $invoices = ListGenerator::Orders($users, $pastries);
} catch (Exception $e) {
}

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