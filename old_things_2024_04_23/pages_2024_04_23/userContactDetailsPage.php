<?php declare(strict_types=1);

use app\models\concretes\StateClass;

if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$user = unserialize($_SESSION['user']);
$pageTitle = 'Manage Your Postal Addresses and Phone Number ' . $user->printName();

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
    <div class="addButton">
        <button type="button" id="addressFormButton" onclick="showAddressForm()">Add a New Address</button>
    </div>
    <div class="popup">
        <form id="newAddressForm" name="newAddressForm" method="post" action="processAddressForm.php">
            <fieldset>
                <legend>Add a Postal Address</legend>
                <p>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" size="60" required>
                </p>
                <p>
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" size="30" required>
                </p>
                <p>
                    <?php echo StateClass::getSelector(); ?>
                <label for="zipcode">Zipcode</label>
                <input type="text" name="zipcode" id="zipcode" size="5" pattern="[0-9]{5}" required/>
                </p>
                <p>
                    <input type="checkbox" id="billingAddressCheckbox" name="billingAddressCheckbox" value="Billing Address">
                    <label for="billingAddressCheckbox">Billing Address</label>
                </p>
            </fieldset>
        </form>
    </div>
    <div>
        <table>
            <tr id="billingAddressRow">
                <td>Your address</td>
                <td> <?php echo $user->getBillingAddress(); ?></td>
                <td>
                    <button
                        type="button"
                        id="updateBillingAddressButton"
                        onclick="location.href='updateBillingAddressForm.php'">
                        Change Your Billing Address
                    </button>
                </td>
            </tr>
            <tr id="telephoneRow">
                <td>Your phone number</td>
                <td><?php echo $user->getPhone(); ?></td>
                <td>
                    <button
                        type="button"
                        id="updateTelephoneButton"
                        onclick="showPhoneForm()">
                        Change Your Phone Number
                    </button>
                </td>
            </tr>
        </table>
    </div>
    <script>
        function showPhoneForm () {
            document.getElementById("phoneForm").removeAttribute("hidden");
            // $elem.removeAttribute("hidden");
            // $elem.style.display = "block";
            // alert("You click on the phone update button");
            // $elem.removeAttribute("hidden");
        }
    </script>
    <div>
        <h2>Your Shipping Addresses</h2>
        <?php echo $user->getShippingAddresses()->toTable(); ?>
    </div>

    <div class="popup">
        <form
            class="popup"
            id="phoneForm"
            name="phoneForm"
            method="post"
            action="processPhoneForm.php"
            hidden
        >
            <fieldset>
                <legend>Update Your Phone Number</legend>
                <div class="formElement">
                    <p>
                        <label for="phone">Phone</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="<?php echo $user->getPhone(); ?>"
                            title="Enter your phone number"
                        >
                    </p>
                </div>
                <div class="formElement">
                    <input type="submit" id="submitPhoneFormButton" name="submitPhoneFormButton" value="Submit">
                </div>
            </fieldset>
        </form>
    </div>
</main>
<footer>
</footer>
</body>
</html>