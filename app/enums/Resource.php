<?php

namespace app\enums;

enum Resource: string {
    case INVENTORY = 'inventory';
    case REVIEWS = 'reviews';
    case ORDERS = 'orders';
    case CART = 'cart';
    case WISHLIST = 'wishlist';
}