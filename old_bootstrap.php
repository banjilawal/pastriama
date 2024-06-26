<?php declare(strict_types=1);
namespace {
    require_once 'vendor/autoload.php';
    require_once 'constants.php';

//    define("UNDELIVERED_DATE", DateTime::createFromFormat('Y-m-d', '2525-01-01'));
//
//    const PROJECT_ROOT = __DIR__;
//    const APP = PROJECT_ROOT . '\app';
//    const TEST = PROJECT_ROOT . '\test';
//    const DATASETS = TEST . '\datasets';
// //   const FOOD_IMAGES = DATASETS . '\pictures';
//    const TESTING_DATASETS = PROJECT_ROOT . '\testing_datasets';
//    const FOOD_IMAGES = TESTING_DATASETS . '\pictures';
//    const FIRSTNAMES = TESTING_DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv';
//    const LASTNAMES = TESTING_DATASETS . DIRECTORY_SEPARATOR . 'lastnames.txt';
//    const ADDRESSES = TESTING_DATASETS . DIRECTORY_SEPARATOR . 'addresses.csv';
//    const FOODS = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'foods.csv';
//    const IMAGES = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'pictures';
//    const FOOD_REVIEWS = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_reviews.csv';
//
////const ASSETS =  PROJECT_ROOT . '\assets';
//    const WEBPAGES = PROJECT_ROOT . '\webpages';
//    const WEBPAGE_COMPONENTS = WEBPAGES . '\components';
//    const NAVIGATION_PAGES = WEBPAGE_COMPONENTS . '\navigation';
//
////    echo nl2br('From bootstrap.php: Datasets_PATH = ' . DATASETS . PHP_EOL);
//    echo nl2br('From bootstrap.php: Testing_Datasets_PATH = ' . TESTING_DATASETS . PHP_EOL);
//
////$files = scandir(DATASETS);
////print_r($files);
//
//
//    const DATE_FORMAT = 'Y-m-d';
//    const DATE_TIME_FORMAT = 'Y-m-d h:m:s.n';
//    const LOWEST_PRICE = 1;
//    const HIGHEST_PRICE = 3;
//    const DEFAULT_TAX_PERCENTAGE = 5;
//    const MINIMUM_TAX_PERCENTAGE = 0;
//    const MAXIMUM_TAX_PERCENTAGE = 35;
//    const EMAIL_MAXIMUM_EXTRA_CHARS = 4;
//    const MINIMUM_CREDIT_CARDS = 1;
//    const MAXIMUM_CREDIT_CARDS = 6;
//
//    const MINIMUM_ADDRESSES = 1;
//    const MAXIMUM_ADDRESSES = 4;
//
//    const RESTOCK_LEVEL = 12;
//    const MAX_QUANTITY_PER_ORDER = 12;
//    const DEFAULT_RESTOCK_QUANTITY = 144;
//
//    const MINIMUM_CREDIT_CARD_LENGTH = 16;
//    const MAXIMUM_CREDIT_CARD_LENGTH = 20;
//    const CREDIT_CARD_CVN_PATTERN = '/[0-9]{3}/';
//    const CREDIT_CARD_NUMBER_PATTERN = '/([0-9]{4,} ){4,}/i';
//
////    define ('FIRSTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv');
////    define ('LASTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'lastnames.txt');
////    define ('ADDRESSES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'addresses.csv');
////    define ('FOODS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'foods.csv');
////    define ('IMAGES', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'pictures');
////    define ('FOOD_REVIEWS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_reviews.csv');
//
//    const EMAIL_SEPARATORS = array('', '.', '_', '-');
//
//    const LETTERS = array(
//        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I',
//        'J', 'K', 'L', 'M', 'N', 'P', 'O', 'Q', 'R',
//        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
//    );
//
//    const UNAMBIGUOUS_LETTERS = array(
//        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
//        'J', 'K', 'M', 'N', 'P', 'Q', 'R', 'S',
//        'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
//    );
//
//    const ALPHA_NUMERICS = array(
//        '1', '2', '3', '4', '5', '6', '7',
//        '8', '9', 'A', 'B', 'C', 'D', 'E',
//        'F', 'G', 'H', 'J', 'K', 'M', 'N',
//        'P', 'Q', 'R', 'S', 'T', 'U', 'V',
//        'W', 'X', 'Y', 'Z'
//    );
//
//    const EMAIL_PROVIDERS = array(
//        'gmail.com', 'yahoo.com', 'hotmail.com', 'aol.com', 'hotmail.co.uk', 'hotmail.fr', 'msn.com', 'yahoo.fr',
//        'wanadoo.fr', 'orange.fr', 'comcast.net', 'yahoo.co.uk', 'yahoo.com.br', 'yahoo.co.in', 'live.com', 'rediffmail.com',
//        'free.fr', 'gmx.de', 'web.de', 'yandex.ru', 'ymail.com', 'libero.it', 'outlook.com', 'uol.com.br', 'bol.com.br',
//        'mail.ru', 'cox.net', 'hotmail.it', 'sbcglobal.net', 'sfr.fr', 'live.fr', 'verizon.net', 'live.co.uk', 'googlemail.com',
//        'yahoo.es', 'ig.com.br', 'live.nl', 'bigpond.com', 'terra.com.br', 'yahoo.it', 'neuf.fr', 'yahoo.de', 'alice.it',
//        'rocketmail.com', 'att.net', 'laposte.net', 'bellsouth.net', 'yahoo.in', 'hotmail.es', 'charter.net', 'yahoo.ca',
//        'yahoo.com.au', 'rambler.ru', 'hotmail.de', 'tiscali.it', 'shaw.ca', 'yahoo.co.jp', 'sky.com', 'earthlink.net',
//        'optonline.net', 'freenet.de', 't-online.de', 'aliceadsl.fr', 'virgilio.it', 'home.nl', 'qq.com', 'telenet.be', 'me.com',
//        'yahoo.com.ar', 'tiscali.co.uk', 'yahoo.com.mx', 'voila.fr', 'gmx.net', 'mail.com', 'planet.nl', 'tin.it', 'live.it',
//        'ntlworld.com', 'arcor.de', 'yahoo.co.id', 'frontiernet.net', 'hetnet.nl', 'live.com.au', 'yahoo.com.sg', 'zonnet.nl',
//        'club-internet.fr', 'juno.com', 'optusnet.com.au', 'blueyonder.co.uk', 'bluewin.ch', 'skynet.be', 'sympatico.ca',
//        'windstream.net', 'mac.com', 'centurytel.net', 'chello.nl', 'live.ca', 'aim.com', 'bigpond.net.au'
//    );

    /**
     * @throws Exception
     */
    function sanitize_input ($data): string {
        if (!isset($data)) {
            Throw new \Exception($data . ' Cannot process null data');
        }
        $data = trim($data, " \t\n\r\0\x0B.");
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    function println (string $string) : string {
        return nl2br($string . PHP_EOL);
    }

    function yearSelector (
        DateTime $startYear,
        int $numberOfYears=5,
        string $id='expirationYear',
        string $label='Expiration Year'
    ): string {
        $currentYear= (int) date('Y');
        $elem = '<label for="' . $id . '">' . $label . '</label>'
            . '<select name=' . $id . '" id="' . $id . '">';
        for ($i = 0; $i < $numberOfYears; $i++) {
            $year = $currentYear + $i;
            $elem .= '<option value="' . $year . '">' . $year . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}