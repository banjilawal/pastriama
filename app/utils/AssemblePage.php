<?php

namespace app\utils;

use app\interfaces\Dashboard;
use app\interfaces\PageAssembler;
use app\pages\Generate;
use app\pages\Page;

class AssemblePage implements PageAssembler {
    public static function htmlHead (string $title): string {
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
            . '<div>' . self::loginForm() . '</div>'
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

    public static function buildDeepMain (Dashboard $dashboard): string {
        return '<main>' . '<h2>' . $dashboard->getMainSectionHeading() . '</h2>' . $dashboard->dashboard() . '</main>';
    }

    public static function buildDeepBody (Dashboard $dashboard): string {
        return '<body>' . '<h1>' . $dashboard->getBodyHeading() . '</h1>'
            . self::buildDeepMain($dashboard) . '</body>';
    }


    public static function buildSimpleMain (Page $page): string {
        return '';
    }

    public static function buildSimpleBody (Page $page): string {
        return '<body>' . '<h1>' . $page->getBodyHeading() . '</h1>'
            . self::buildSimpleMain($page) . '</body>';
    }

    public static function factory (Page $page): string {
        if ($page instanceof Dashboard) {
            return self::htmlHead($page->getTitle())
                . self::header()
                . self::navbar()
                . self::buildDeepBody($page)
                . self::footer();
        }
        return self::htmlHead($page->getTitle())
            . self::header()
            . self::navbar()
            . self::buildSimpleBody($page)
            . self::footer();
    }

    public static function assemble (Page $page): string {
        return self::factory($page);
    }


}