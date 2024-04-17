<?php declare(strict_types=1);
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'bootstrap.php';
//require_once 'WebPage.php';

use app\models\concretes\CreditCard;
use app\models\concretes\User;
//use app\models\lists\CreditCardList;
//use app\test\EntityGenerator;


//class CreditCardPage extends WebPage {
//
//    private User $user;
//
//    public function __construct (User $user) {
//        parent::__construct('Your Credit Cards ' . $user->printName());
//        $this->user = $user;
//    }
//
//    public function getUser (): User {
//        return $this->user;
//    }
//
//    public function getCreditCards (): CreditCardList {
//        return $this->user->getCreditCards();
//    }
//
//    public function getCreditCardTable (): string {
//        $elem = '<table class="table" id="credit-cards-table">'
//            . '<thead>'
//            . '<tr>'
//            . '<th>Row</th>'
//            . '<th>CardId</th>'
//            . '<th>Vendor</th>'
//            . '<th>Ending With</th>'
//            . '<th>Expiration</th>'
//            . '<th hidden>View Transactions</th>'
//            . '<th hidden>Remove</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>';
//        $counter = 1;
//        foreach ($this->user->getCreditCards()->getItems() as $card) {
//            $elem .= '<tr id="row' . $counter . '">' // onclick="rowClickHandler()">'
//                . '<td>' . $counter . '</td>'
//                . '<td>' . $card->getId() . '</td>'
//                . '<td>'. $card->getVendor() . '</td>'
//                . '<td>***- ' . $card->securelyPrintCardNumber() . '</td>'
//                . '<td>' . $card->printExpirationDate() . '</td>'
//                . '<td>'
//                        . '<button name="transactionsButton" '
//                        . 'id="' . $card->getId() . '"'
//                        . 'onclick="getCardTransactions(event)">View Transactions'
//                        . '</button>'
//                . '</td>'
//                . '<td>'
//                        . '<button name="removeCardButton" '
//                        . 'id="' . $card->getId() . '"'
//                        . 'onclick="removeCardButtonClickHandler(event)">Remove'
//                        . '</button>'
//                . '</td>'
//                . '</tr>';
//            $counter++;
//        }
//        $elem .= '<tbody></table>';
//        return $elem;
//    }
//
//    public function getVendorSelector (): string {
//        $elem = '<label for="vendor">Credit Card Type</label>'
//            . '<select id="vendor" name="vendor" required>';
//        foreach (EntityGenerator::CREDIT_CARD_VENDORS as $vendor) {
//            $elem .= '<option value"' . $vendor . '">' . $vendor . '</option>';
//        }
//        $elem .= '</select>';
//        return $elem;
//    }
//
//
//
////    public function searchByCookie (string $cookieValue): CreditCard {
////        return $this->getCreditCards()->searchById((int) trim($cookieValue));
////    }
//}

$user = unserialize($_SESSION['user']);
$title = 'Your Credit Cards ' . $user->printName();
//function getCreditCardTable (User $user): string {
//    $elem = '<table class="table" id="creditCardTable">'
//        . '<thead>'
//        . '<tr>'
//        . '<th>Row</th>'
//        . '<th>CardId</th>'
//        . '<th>Vendor</th>'
//        . '<th>Ending With</th>'
//        . '<th>Expiration</th>'
//        . '<th hidden>View Transactions</th>'
//        . '<th hidden>Remove</th>'
//        . '</tr>'
//        . '</thead>'
//        . '<tbody>';
//    $counter = 1;
//    foreach ($user->getCreditCards()->getItems() as $card) {
//        $elem .= '<tr id="row' . $counter . '">' // onclick="rowClickHandler()">'
//            . '<td>' . $counter . '</td>'
//            . '<td>' . $card->getId() . '</td>'
//            . '<td>'. $card->getVendor() . '</td>'
//            . '<td>***- ' . $card->securelyPrintCardNumber() . '</td>'
//            . '<td>' . $card->printExpirationDate() . '</td>'
//            . '<td>'
//                    . '<button name="transactionsButton" '
//                    . 'id="' . $card->getId() . '"'
//                    . 'onclick="getCardTransactions(event)">View Transactions'
//                    . '</button>'
//            . '</td>'
//            . '<td>'
//                    . '<button name="removeCardButton" '
//                    . 'id="' . $card->getId() . '"'
//                    . 'onclick="removeCardButtonClickHandler(event)">Remove'
//                    . '</button>'
//            . '</td>'
//            . '</tr>';
//        $counter++;
//    }
//    $elem .= '<tbody></table>';
//    return $elem;
//}
//$lists = null;
//try {
//    $lists = ListGenerator::lists(30, 60);
//} catch (Exception $e) {
//    echo $e;
//}
//$user = $lists['users']->getItems()[array_rand($lists['users']->getItems())];
//foreach($lists['users']->getItems() as $u) {
//    echo $u . PHP_EOL;
//}
//echo $user;
//$creditCard = EntityGenerator::pickCreditCard($user);
//$invoices = $lists['invoices']->filterByCreditCard($creditCard);
//$page = new CreditCardPage($user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css"/>
    <title>
        <?php echo $title; ?>
    </title>
</head>
<body>
<header>
</header>
    <?php echo '<h1>' . $title . '</h1>'; ?>
<main>
    <div class="dashboard">
      <h2>Your Current Cards</h2>
        <p>
            "<?php echo $user->getCreditCards()->toTable(); ?>
            <script>
                function transactionButtonHandler(event) {
                    document.cookie = "cardID=" + event.target.id + "";
                    location.href = "CreditCardPage.php";
                    alert("Getting transactions for card with ID " + document.cookie);
                }

                function removeButtonHandler (event) {
                    let xhr = new XMLHttpRequest();
                    xhr.open('GET', 'id.txt', true);
                    xhr.onload = function(){
                        if (this.status === 200) {
                            alert(this.responseText);
                        }
                        xhr.send();
                    }
                    // sessionStorage.setItem("cardId", event.target.id);
                    // let elem = event.target;
                    // let expirationTime = new Date().getTime() + 60000;
                    // document.cookie = "cardId=" + event.target.id + ";"; // expires=" + expirationTime.toUTCString() + ";";
                    // alert(sessionStorage.getItem("cardId"));
                    // xhttp.open("POST", "creditCardPage.php", true);
                    // xhttp.send()
                }
            </script>
        </p
    </div>
    <div class="form">
        <h2>Add a New Credit Card</h2>
        <form
            id="addCreditCardForm"
            name="addCreditCardForm"
            method="post"
            action="app/processors/processAddCardForm.php"
        >
            <fieldset name="cardInformationFieldset" id="cardInformationFieldset">
                <legend>Credit Card Information</legend>
                <div class="formElement">
                    <?php echo CreditCard::getVendorSelector(); ?>
                </div>
                <div class="formElement">
                    <p>
                        <label for="nameOnCard">Card Holder</label>
                        <input
                            type="text"
                            id="nameOnCard"
                            name="nameOnCard"
                            size="100"
                            required
                            <?php echo 'value="' . $user->printName() . '"'; ?>
                        >
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="number">Card Number</label>
                        <input
                            type="text"
                            id="number"
                            name="number"
                            pattern="[0-9]{4,5}( [0-9]{4,5}){3,4}"
                            size="40"
                            required
                            title="Please enter the credit card number"
                        >
                    </p>
                </div>
                <div class="formElement">
                    <p>
                       <label for="cvn">CVN</label>
                        <input
                            type="text"
                            id="cvn"
                            name="cvn"
                            pattern="[0-9]{3,4}"
                            size="4"
                            required
                            title="Please enter the 3-4 digit CVN number on the back of your card"
                        >
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <?php
                            echo CreditCard::getExpirationMonthSelector();
                            echo CreditCard::getExpirationYearSelector();
                        ?>
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <input type="reset" name="cancelButton" id="cancelButton" value="Cancel">&nbsp;
                        <input type="submit" name=submitButton" id="submitButton" value="Submit">
                    </p>
                </div>
            </fieldset>
        </form>
    </div>
    <div>
        <?php
            $creditCard = $user->getCreditCards()->getItems()[array_rand($user->getCreditCards()->getItems())];
            echo nl2br('picked card ' . $creditCard . PHP_EOL);
            echo '<h2>Transactions for Card ***-' . $creditCard->securelyPrintCardNumber() . '</h2>';
            echo unserialize($_SESSION['orders'])->filterByCreditCard($creditCard)->toTable();
        ?>
    </div>


    <?php
    //    foreach ($_SESSION as $key => $value) {
    //        echo nl2br($key . PHP_EOL);
    //    }
//        echo $page->searchByCookie($_COOKIE['cardId']);
    ?>
</main>
<footer>
</footer>
</body>
</html>