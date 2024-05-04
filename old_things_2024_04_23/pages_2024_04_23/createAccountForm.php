<?php declare(strict_types=1);
if (empty(session_id())) {
    session_start();
}

use app\enums\CreditCardProvider;
use app\enums\Month;
use app\enums\State;
use app\test\EntityGenerator;
use app\test\ListGenerator;

require_once 'bootstrap.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../../styles.css"/>
    <title>
        Register for an Account
    </title>
</head>
<body>
<header>

</header>
<main>
    <div class="form">
        <h1>Register for a New Account</h1>
        <form name="registrationForm" id="registrationForm" action="processRegistrationForm.php" method="post">
            <fieldset name="contactInformation" id="contactInformation">
                <legend>Contact Information</legend>
                <div class="formElement">
                    <p>
                        <label for="firstname">Firstname</label>
                        <input type="text" id="firstname" name="firstname" size="30" required>
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="lastname">Lastname</label>
                        <input type="text" id="lastname" name="lastname" size="30" required>
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" size="20" required>
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" size="60" required>
                    </p>
                    <p>
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" size="30" required>
                    </p>
                    <p><?php echo State::selector(); ?></p>
<!--                    <p>-->
<!--                        <label for="state">State</label>-->
<!--                        <select name="state" id="state" required>-->
<!--                            <option value="">--select a state--</option>-->
<!--                            <option value="AL">Alabama</option>-->
<!--                            <option value="AK">Alaska</option>-->
<!--                            <option value="American Samoa AS">American Samoa</option>-->
<!--                            <option value="AZ">Arizona</option>-->
<!--                            <option value="Arkansas AR">Arkansas</option>-->
<!--                            <option value="Armed Forces Americas AA">Armed Forces Americas</option>-->
<!--                            <option value="Armed Forces Europe AE">Armed Forces Europe</option>-->
<!--                            <option value="Armed Forces Pacific AP">Armed Forces Pacific</option>-->
<!--                            <option value="CA">California</option>-->
<!--                            <option value="CO">Colorado</option>-->
<!--                            <option value="CT">Connecticut</option>-->
<!--                            <option value="DE">Delaware</option>-->
<!--                            <option value="DC">District of Columbia</option>-->
<!--                            <option value="Federated States of Micronesia FM">Federated States of Micronesia</option>-->
<!--                            <option value="FL">Florida</option>-->
<!--                            <option value="GA">Georgia</option>-->
<!--                            <option value="GU">Guam</option>-->
<!--                            <option value="HI">Hawaii</option>-->
<!--                            <option value="ID">Idaho</option>-->
<!--                            <option value="IL">Illinois</option>-->
<!--                            <option value="Indiana IN">Indiana</option>-->
<!--                            <option value="Iowa IA">Iowa</option>-->
<!--                            <option value="Kansas KS">Kansas</option>-->
<!--                            <option value="Kentucky KY">Kentucky</option>-->
<!--                            <option value="Louisiana LA">Louisiana</option>-->
<!--                            <option value="Maine ME">Maine</option>-->
<!--                            <option value="Marshall Islands MH">Marshall Islands</option>-->
<!--                            <option value="Maryland MD">Maryland</option>-->
<!--                            <option value="Massachusetts MA">Massachusetts</option>-->
<!--                            <option value="Michigan MI">Michigan</option>-->
<!--                            <option value="Minnesota MN">Minnesota</option>-->
<!--                            <option value="Mississippi MS">Mississippi</option>-->
<!--                            <option value="Missouri MO">Missouri</option>-->
<!--                            <option value="Montana MT">Montana</option>-->
<!--                            <option value="Nebraska NE">Nebraska</option>-->
<!--                            <option value="Nevada NV">Nevada</option>-->
<!--                            <option value="New Hampshire NH">New Hampshire</option>-->
<!--                            <option value="New Jersey NJ">New Jersey</option>-->
<!--                            <option value="New Mexico NM">New Mexico</option>-->
<!--                            <option value="New York NY">New York</option>-->
<!--                            <option value="North Carolina NC">North Carolina</option>-->
<!--                            <option value="North Dakota ND">North Dakota</option>-->
<!--                            <option value="Northern Mariana Islands MP">Northern Mariana Islands</option>-->
<!--                            <option value="OH">Ohio</option>-->
<!--                            <option value="Oklahoma OK">Oklahoma</option>-->
<!--                            <option value="Oregon OR">Oregon</option>-->
<!--                            <option value="Palau PW">Palau</option>-->
<!--                            <option value="Pennsylvania PA">Pennsylvania</option>-->
<!--                            <option value="Puerto Rico PR">Puerto Rico</option>-->
<!--                            <option value="Rhode Island RI">Rhode Island</option>-->
<!--                            <option value="South Carolina SC">South Carolina</option>-->
<!--                            <option value="SD">South Dakota</option>-->
<!--                            <option value="TN">Tennessee</option>-->
<!--                            <option value="TTX">Texas</option>-->
<!--                            <option value="UT">Utah</option>-->
<!--                            <option value="VT">Vermont</option>-->
<!--                            <option value="VI">Virgin Islands</option>-->
<!--                            <option value="VA">Virginia</option>-->
<!--                            <option value="WA">Washington</option>-->
<!--                            <option value="WV">West Virginia</option>-->
<!--                            <option value="WI">Wisconsin</option>-->
<!--                            <option value="WY">Wyoming</option>-->
<!--                        </select>-->

                        <label for="zipcode">Zipcode</label>
                        <input type="text" name="zipcode" id="zipcode" size="5" pattern="[0-9]{5}" required/>
                    </p>
                </div>
            </fieldset>
            <fieldset id="creditCardInformation" name="creditCardInformation">
                <legend>Credit Card Information</legend>
                <div class="formElement">
                    <p><?php echo CreditCardProvider::selector(); ?></p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="nameOnCard">Card Holder</label>
                        <input type="text" name="nameOnCard" id="nameOnCard" size="50" required/>
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="number">Card Number</label>
                        <input
                            type="text"
                            name="number"
                            id="number"
                            pattern="[0-9]{4,5}( [0-9]{4,5}){3,4}"
                            size="40"
                            required
                            title="Please enter the credit card number"
                        />
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="cvn">CVN</label>
                        <input
                            type="text"
                            name="cvn"
                            id="cvn"
                            pattern="[0-9]{3,4}"
                            size="4"
                            required
                            title="Please enter the 3-4 digit CVN number on the back of your card"
                        />
                    </p>
                </div>
                <div class="formElement">
                    <?php
                        echo '<p>' . Month::selector() . '</p>';
                        echo '<p>' . EntityGenerator::yearSelector(DateTime::createFromFormat('Y', date('Y'))) . '</p>';
                    ?>
                </div>
            </fieldset>
            <fieldset name="loginInformation" id="loginInformation">
                <legend>Create Your Login</legend>
                <div class="formElement">
                    <p>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" size="30" required>
                    </p>
                </div>
                <div class="formElement">
                    <p>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" size="30" required>
                    </p>
                </div>
                <div class="formElement">
                    <button type="reset" name="cancelButton" id="cancelButton">Cancel</button>&nbsp;
                    <button type="submit" name="submitButton" id="submitButton" value="register">Register</button>
                </div>
            </fieldset>
        </form>
    </div>
</main>
<footer>
</footer>
</body>
</html>