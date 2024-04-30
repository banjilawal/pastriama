<?php declare(strict_types=1);
function getHead (string $title): string {
    return '<!DOCTYPE html><html lang="en">'
        . '<head>'
            . '<meta charset="UTF-8">'
            . '<link rel="stylesheet" href="../../styles.css"/>'
            . '<title>'.  $title . '</title>'
        . '</head>';
}

function getHeader ():  string {
    return '<header>'
        . '<div class="gridItem">PUT_LOGO_HERE</div>'
        . '<div class="gridItem">Search</div>'
        . '<div class="gridItem">Hi User</div>'
        . '<div class="gridItem">Shopping Cart</div>'
        . '<div class="gridItem">Help</div>'
        . '</header>';
}

function getNavbar (): string {
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
        . '</nav>';
}

function getFooter (): string {
    return '<footer></footer>';
}