<?php

namespace app\enums;

enum FormType: string  {
    case ORDER = 'order';
    case LOGIN = 'login';
    case PHONE = 'phone';

    case REVIEW = 'review';
    case ADD_TO_CART = 'addToCart';
    case CREDIT_CARD = 'creditCard';
    case ONE_CLICK_BUY = 'oneClickBuy';
    case SHOPPING_CART = 'shoppingCart';
    case PASSWORD_RESET = 'passwordReset';
    case POSTAL_ADDRESS = 'postalAddress';
}