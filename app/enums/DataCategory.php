<?php

namespace app\enums;

enum DataCategory: string {
    case FIRSTNAME = 'firstname';
    case LASTNAME = 'lastname';
    case ADDRESS = 'address';
    case FOOD = 'food';
    case FOOD_REVIEW = 'foodReview';
    case FOOD_PICTURE = 'foodPicture';

}