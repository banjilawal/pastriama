<?php declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'WebPage.php';

use app\models\concretes\Invoice;
use app\test\ListGenerator;


class InvoicePage extends WebPage {
    private Invoice $invoice;

    public function __construct (Invoice $invoice) {
        parent::__construct('Invoice# ' . $invoice->getId() . ' Details'); //  $invoice->getSubmissionTime()->format('Y-m-d H:i:s'));
        $this->invoice = $invoice;
    }

    public function getInvoice (): Invoice {
        return $this->invoice;
    }

    private function printDeliveryAddress (): string {
        return $this->invoice->getUser()->getFirstname() . ' ' . $this->invoice->getUser()->getLastname() . '<br>' . PHP_EOL
            . $this->invoice->getUser()->getPostalAddress()->getStreet() . '<br>' . PHP_EOL
            . $this->invoice->getUser()->getPostalAddress()->getCity() . '<br>' . PHP_EOL
            . $this->invoice->getUser()->getPostalAddress()->getState() . ' '
            . $this->invoice->getUser()->getPostalAddress()->getZipcode() . '<br>' . PHP_EOL;
    }

    public function deliveryDetailsTable (): string {
        $elem = '<table>'
            . '<thead>'
            . '<tr>'
            . '<th>Order Placed</th>'
            . '<th>Total</th>'
            . '<th>Payment Method</th>'
            . '<th>Ship To</th>'
            . '<th>Delivered On</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->invoice->getSubmissionTime()->format('Y-m-d') . '</td>'
            . '<td>' . number_format($this->invoice->getItems()->getTotalCharge(), 2) . '</td>'
            . '<td>Card ending **' . $this->invoice->getCreditCard()->getSecureNumber() . '</td>'
            . '<td>' . $this->invoice->getUser()->getPostalAddress() . '</td>'
            . '<td>' . $this->invoice->getRealDeliveryDate()->format('Y-m-d') . '</td>'
            . '</tr>'
            . '</tbody></table>';
        return $elem;
    }
} // end class InvoicePage
$lists = null;
try {
    $lists = ListGenerator::lists(30, 60);
} catch (Exception $e) {
    echo $e;
}
$invoice = $lists['invoices']->getItems()[array_rand($lists['invoices']->getItems())];
$page = new InvoicePage($invoice);
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
        echo '<p>' . $page->deliveryDetailsTable() . '</p>';
//        echo '<p><h2>Delivered on ' . $page->getInvoice()->getRealDeliveryDate()->format('Y-m-d') . '</h2></p>';
//        echo '<h2>Order Items</h2>';
        echo '<p>' . $page->getInvoice()->toTable() . '</p>';
    ?>
</main>
<footer>
</footer>
</body>
</html>