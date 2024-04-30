<?php

namespace app\enums;

enum EntityList: string {
    case CREDIT_CARDS = 'creditCard';
    case ADDRESSES = 'addresses';
    case SHOPPING_CART = 'shoppingCart';
}