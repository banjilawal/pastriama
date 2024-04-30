<?php declare(strict_types=1);
namespace old_things_2024_04_23\pages_2024_04_23;
session_start();

require_once 'bootstrap.php';
require_once 'WebPage.php';

use app\models\concretes\NewOrder;
use app\test\ListGenerator;


class InvoicePage extends WebPage {
    private NewOrder $order;

    public function __construct (NewOrder $order) {
        parent::__construct('Order# ' . $order->getId() . ' Details'); //  $invoice->getSubmissionTime()->format('Y-m-d H:i:s'));
        $this->order = $order;
    }

    public function getOrder (): NewOrder {
        return $this->order;
    }

    private function printDeliveryAddress (): string {
        return $this->order->getUser()->getFirstname() . ' InvoicePage.php' . $this->order->getUser()->getLastname() . '<br>' . PHP_EOL
            . $this->order->getUser()->getPostalAddress()->getStreet() . '<br>' . PHP_EOL
            . $this->order->getUser()->getPostalAddress()->getCity() . '<br>' . PHP_EOL
            . $this->order->getUser()->getPostalAddress()->getState() . ' '
            . $this->order->getUser()->getPostalAddress()->getZipcode() . '<br>' . PHP_EOL;
    }

    public function deliveryDetailsTable (): string {
        return '<table>'
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
            . '<td>' . $this->order->getSubmissionTime()->format('Y-m-d') . '</td>'
            . '<td>' . number_format($this->order->getInvoice()->getTotalCharge(), 2) . '</td>'
            . '<td>Card ending **' . $this->order->getCreditCard()->getSecureNumber() . '</td>'
            . '<td>' . $this->order->getShipToAddress() . '</td>'
            . '<td>' . $this->order->getDateDelivered()->format('Y-m-d') . '</td>'
            . '</tr>'
            . '</tbody></table>';
//        return $elem;
    }
} // end class old_things_2024_04_23\pages_2024_04_23\InvoicePage
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
    <link rel="stylesheet" type="text/css" href="styles.css"/>
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
    echo '<p>' . $page->getOrder()->toTable() . '</p>';
    ?>
</main>
<footer>
</footer>
</body>
</html>