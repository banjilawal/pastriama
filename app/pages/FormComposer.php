<?php

namespace app\pages;

use app\models\concretes\Product;
use app\models\concretes\User;

class FormComposer {

    public static function oneClickBuyForm (Product $product, User $user): string {
        return '<div class="popUp">'
            . '<form class="popUp" id="oneClickBuyForm" name="oneClickBuyForm" method="post" action="processOneClickBuyForm.php">'
            . '<fieldset>'
            . '<legend>Buy with One Click</legend>'
            . '<div class="formElement"><p>' . $user->getCreditCards()->selector() . '</p></div>'
            . '<div class="formElement"><p>' . $user->getShippingAddresses()->selector() . '</p></div>'
            . '<div class="formElement"><p>' . Product::quantitySelector() . '</p></div>'
            . '<input type="submit" id="oneClickBuyButton" value="Buy with One-Click">'
            . '</div>'
            . '</fieldset>'
            . '</form>'
            . '</div>';
    }
}