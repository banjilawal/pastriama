<?php

namespace app\templates;

//require_once 'styles.css';

class HTMLSection {
    public static function head (string $title): string {
        return '<!DOCTYPE html><html lang="en">'
            . '<head>'
            . '<meta charset="UTF-8">'
            . '<link rel="stylesheet" href="styles.css"/>'
            . '<title>'.  $title . '</title>'
            . '</head>';
    }

    public static function header ():  string {
        return '<header>'
            . '<div class="gridItem">PUT_LOGO_HERE</div>'
            . '<div class="gridItem">Search</div>'
            . '<div class="gridItem">Hi User</div>'
            . '<div class="gridItem">Shopping Cart</div>'
            . '<div class="gridItem">Help</div>'
            . '</header>';
    }

    public static function navbar (): string {
        return '<nav>'
            . '<div class="navItem">'
            . '<input type="search" id="searchBar" name="searchBar"/>'
            . '<label for="searchBar">Search</label>'
            . '</div>'
            . '<div class="navItem">'
            . '<a id="userDashboard" name="userDashboard" href="userDashboard.php">Your Dashboard</a>'
            . '</div>'
            . '<div class="navItem">'
            . '<a id="wishlist" name="wishlist" href="userWishlist.php">Your Wishlist</a>'
            . '</div>'
            . '<div class="navItem">'
            . '<a id="orders" name="orders" href="userOrders.php">Your Orders</a>'
            . '</div>'
            . '<div class="navItem">'
            . '<a id="shoppingCart" name="shoppingCart" href="userShoppingCart.php">Your Shopping Cart</a>'
            . '</div>'
            . HTMLForm::loginForm()
//            . '<div>' . self::loginForm() . '</div>'
            . '</nav>';
    }

    public static function loginForm (): string {
        return '<div class="form">'
                . '<form name="loginForm" id="loginForm" action="processLoginForm.php" method="post">'
                    . '<fieldset name="login" id="login">'
                        . '<legend>Login to Your Account</legend>'
                        . '<div class="formElement">'
                            . '<p>'
                                . '<label for="email">Email</label>'
                                . '<input type="email" name="email" id="email"  size="30" required>'
                            . '</p>'
                        . '</div>'
                        . '<div class="formElement">'
                            . '<p>'
                                . '<label for="password">Password</label>'
                                . '<input type="password" id="password" name="password" size="30" required>'
                            . '</p>'
                        . '</div>'
                        . '<input type="submit" value="login">'
                    . '</fieldset>'
                . '</form>'
            . '</div>';
    }

    public static function footer (): string {
        return '<footer></footer>';
    }
}