<?php declare(strict_types=1);
namespace app\templates;

use app\enums\CreditCardProvider;
use app\enums\FormType;
use app\enums\Month;
use app\enums\State;
use app\enums\StylingClass;
use app\models\collections\InvoiceItems;
use app\models\concretes\InventoryItem;
use app\models\concretes\NewReview;
use app\models\concretes\User;
use DateTime;

define ('ACTION_HOME', 'process/');
define ('FORM_CONTAINER_CSS_CLASS', 'form');
define ('FORM_ELEMENT_CSS_CLASS', 'formItem');
define ('POPUP_FORM_CONTAINER_CLASS', 'popup');
define ('POPUP_ELEMENT_CONTAINER_CLASS', 'popFormItem');
class HTMLForm {

    private static function openingTag (FormType $formType, StylingClass $class): string {
        return '<div class="' . $class->value . '">'
            . '<form name="' . $formType->value . 'HTMLForm " id="' . $formType->value . 'HTMLForm"'
            . ' action="' . ACTION_HOME . $formType->value . 'HTMLForm.php" method="post">';
    }

    public static function loginForm (
//
        StylingClass $class=StylingClass::FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::LOGIN, $class) .'<fieldset name="login" id="login">'
            . '<legend>Login to Your Account</legend>'
            . '<div><p>'
            . '<label for="email">Email</label>'
            . '<input type="email" name="email" id="email"  size="30" required>'
            . '</p></div>'
            . '<div class="formElement"><p>'
                . '<label for="password">Password</label>'
                . '<input type="password" id="password" name="password" size="30" required>'
            . '</p></div>'
            . '<input type="submit" value="login">'
            . '</fieldset>'
            . '</form>'
            . '</div>';
    }

    public static function creditCardFieldset (string $cardHolderName=''): string {
        return '<fieldset>'
            . '<legend>Credit Card Information</legend>'
            . '<div class="formElement">' . CreditCardProvider::selector() . '</div>'
            . '<div class="formElement"><p>'
                . '<label for="nameOnCard">Card Holder</label>'
                . '<input type="text" id="nameOnCard" name="nameOnCard" size="100" required'
                . ' placeholder="' . $cardHolderName .'">'
            . '</p></div>'
            . '<div class="formElement"><p>'
                . '<label for="number">Card Number</label>'
                . '<input type="text" id="number" name="number" pattern="[0-9]{4,5}( [0-9]{4,5}){3,4}" size="40"'
                . ' required title="Please enter the credit card number">'
            . '</p></div>'
            . '<div class="formElement"><p>'
                . '<label for="cvn">CVN</label>'
                . '<input type="text" id="cvn" name="cvn" pattern="[0-9]{3,4}" size="4"'
                . ' required title="Please enter the 3-4 digit CVN number on the back of your card">'
            . '</p></div>'
            . '<div class="formElement"><p>'
                . Month::selector() . yearSelector(DateTime::createFromFormat('Y', date('Y')))
            . '</p></div>'
            . '<div class="formElement"><p>'
                . '<input type="reset" name="cancelButton" id="cancelButton" value="Cancel">&nbsp;'
                . '<input type="submit" name=submitButton" id="submitButton" value="Submit">'
            . '</p>
            . </div>'
            . '</fieldset>';
    }

    public static function creditCardForm (
        User $user,
        StylingClass $class=StylingClass::FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::CREDIT_CARD, $class) . self::creditCardFieldset($user->printName())
            . '</form></div>';
    }

    public static function reviewForm (
        StylingClass $class=StylingClass::FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::REVIEW, $class) . '<fieldset>'
            . '<legend>Write a Review></legend>'
			. '<div class="formElement"><p>' . NewReview::ratingSelector() . '</p></div>'
            . '<div class="formElement"><p>'
                . '<label for="reviewTitle">Title</label>'
                . '<input type="text" id="reviewTitle" name="reviewTitle" size="50" required>'
            . '</p></div>'
            . '<div class="formElement"><p>'
                . '<label for="comment">Comment</label><br>'
                . '<textarea id="comment" name="comment" cols="100">...</textarea>'
            . '</p></div>'
            . '<input type="submit" id="submitRating" name="submitRating" value="Add Your Rating">'
            . '</fieldset>'
            . '</form>'
            . '</div>';
    }

    public static function oneClickBuyForm (
        User $user, 
//        string $name='oneClickBuy',
        StylingClass $class=StylingClass::POPUP_FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::ONE_CLICK_BUY, $class) . '<fieldset>'
            . '<legend>Buy with One Click</legend>'
            . '<div class="formElement"><p>' . $user->getCreditCards()->selector() . '</p></div>'
            . '<div class="formElement"><p>' . $user->getShippingAddresses()->selector() . '</p></div>'
            . '<div class="formElement">'
            . '<input type="submit" id="oneClickBuyButton" value="Buy with One-Click">'
            . '</div>'
            . '</fieldset>'
            . '</form>';
    }

    public static function phoneFieldset (string $previousPhoneNumber=''): string {
        return '<fieldset>'
        . '<legend>Update Your Phone Number</legend>'
        . '<div class="formElement"><p>'
            . '<label for="phone">Phone</label>'
            . '<input type="tel" id="phone" name="phone" placeholder="' . $previousPhoneNumber
            . '" title="Enter your phone number">'
        . '</p></div>'
        . '<div class="formElement">'
            . '<input type="submit" id="submitPhoneFormButton" name="submitPhoneFormButton" value="Submit">'
        . '</div>'
        . '</fieldset>';
    }

    public static function phoneForm (
        User $user, 
//        string $name='phone',
        StylingClass $class=StylingClass::POPUP_FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::PHONE, $class)
            . self::phoneFieldset($user->getPhone()->__toString()) . '</form></div>';
    }

    public static function addToCartForm (
//        string $name='addToCart',
        StylingClass $class=StylingClass::FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::ADD_TO_CART, $class) . '<fieldset>'
		    . '<legend>Add to Your Cart</legend>'
		    . '<div class="formElement"><p>' . InventoryItem::quantitySelector() . '</p></div>'
            . '<p><input type="submit" name="addToCart" id="addToCart" value="Add to Cart"></p>'
            . '</fieldset>'
            . '</form>'
            . '</div>';
    }

    public static function postalAddressFieldset (): string {
        return '<fieldset>'
            . '<legend>Add a Postal Address</legend>'
            . '<div class="formElement">'
            . '<p><label for="address">Address</label><input type="text" id="address" name="address" size="60" required></p>'
            . '<p><label for="city">City</label><input type="text" id="city" name="city" size="30" required></p>'
            . '<p>'
                . State::selector() . '&nbsp;'
                . '<label for="zipcode">Zipcode</label>'
                . '<input type="text" name="zipcode" id="zipcode" size="5" pattern="[0-9]{5}" required/>'
            . '</p>'
            . '</div>'
            . '</fieldset>';
    }

    public static function postalAddressForm (
//        string $name='postalAddress',
        StylingClass $class=StylingClass::FORM_CONTAINER
    ): string { return self::openingTag(FormType::POSTAL_ADDRESS, $class) . self::postalAddressFieldset() . '</form></div>'; }

    public static function passwordFieldset (string $legend): string {
        return '<fieldset>'
            . '<legend>' . $legend . '</legend>'
            . '<div class="formElement"><p>'
                . '<label for="email">Email</label>'
                . '<input type="email" name="email" id="email" size="30" required>'
            . '</p></div>'
            . '<div class="formElement"><p>'
                . '<label for="password">Password</label>'
                . '<input type="password" id="password" name="password" size="30" required>'
            . '</p></div>'
            . '<div class="formElement"><p>'
                . '<label for="passwordConfirmation">Confirm Password</label>'
                . '<input type="password" id="passwordConfirmation" name="passwordConfirmation" size="30" required>'
            . '</p></div>'
            . '<div class="formElement">'
                . '<button type="reset" name="cancelButton" id="cancelButton">Cancel</button>&nbsp;'
                . '<button type="submit" name="submitButton" id="submitButton" value="register">Register</button>'
            . '</div>'
            . '</fieldset>';
    }

    public static function passwordResetForm (
        string $fieldsetLegend,
        string $name='loginCredentials',
        StylingClass $class=StylingClass::FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::PASSWORD_RESET, $class)
            . self::passwordFieldset($fieldsetLegend) . '</form></div>';
    }

    public static function shoppingCartForm (
        User $user, 
//        string $name='shoppingCart',
        StylingClass $class=StylingClass::FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::SHOPPING_CART, $class)
            . '<fieldset>Your Shopping Cart</fieldset>'
            . '<div class="formElement"><p>' . HTMLList::shoppingCart($user) . '</p></div>'
            . '<div class="formElement"><input type="submit" value="Go to Checkout"></div>'
            . '</fieldset>'
            . '</form>'
            . '</div>';
    }

    public static function orderForm (
        InvoiceItems $products,
        User         $user,
//        string $name='order',
        StylingClass $class = StylingClass::FORM_CONTAINER
    ): string {
        return self::openingTag(FormType::ORDER, $class);
    }
}