<?php

namespace global;

require_once('vendor\autoload.php');

class Constants {
    public const MINIMUM_RATING =  0;
    public const MAXIMUM_RATING = 5;
    public const ESTIMATED_TRANSIT_DAYS = 5;
    
    public const ITEM_MINIMUM_PRICE = 1.99;
    public const ITEM_MAXIMUM_PRICE = 5.99;
    

    public const MINIMUM_TAX_PERCENTAGE = 0;
    public const MAXIMUM_TAX_PERCENTAGE = 35;
    public const DEFAULT_TAX_PERCENTAGE = 5;
}