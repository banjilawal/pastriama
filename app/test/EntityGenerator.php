<?php declare(strict_types=1);

namespace app\test;

//require_once '..\..\testing_datasets\food_images'; //'..\..\testing_datasets\food_images';

use app\enums\CreditCardProvider;
use app\enums\State;
use app\models\concretes\CreditCard;
use app\models\concretes\Domain;
use app\models\concretes\EmailAddress;
use app\models\concretes\Order;
use app\models\concretes\Product;
use app\models\concretes\Pastry;
use app\models\concretes\Phone;
use app\models\concretes\PostalAddress;
use app\models\concretes\Review;
use app\models\concretes\User;
use app\models\concretes\Zipcode;
use app\models\lists\Products;
use app\models\lists\Pastries;
use app\models\catalogs\Inventory;
use app\utils\SerialNumber;
use DateTime;
use Exception;

define("BIRTHDATE_FLOOR", DateTime::createFromFormat('Y-m-d', '1940-01-01'));
define("BIRTHDATE_CEILING", DateTime::createFromFormat('Y-m-d', '2006-01-01'));
define('TRANSACTION_DATE_FLOOR', DateTime::createFromFormat('Y-m-d', '2020-01-01'));
define('PICTURES_PATH', '..\..\testing_datasets\food_images');
class EntityGenerator {


    private const MAX_SHIPPING_ADDRESSES = 2;
    private const MIN_PASTRY_PRICE = 1;
    private const MAX_PASTRY_PRICE = 3;

    private const MIN_INVOICE_SIZE = 0;
    private const MAX_INVOICE_SIZE = 4;
    private const MIN_ADDITIONAL_CARDS = 0;
    private const MAX_ADDITIONAL_CARDS = 5;
    private const MINIMUM_ITEM_QUANTITY = 1;
    private const MAXIMUM_ITEM_QUANTITY = 24;

//   private const FIRSTNAMES = DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv'; //DATASETS . '\lastnames.txt';
//    private const LASTNAMES = DATASETS . DIRECTORY_SEPARATOR . 'lastnames.txt'; //DATASETS . '\firstnames.csv';
//    private const ADDRESSES = DATASETS . DIRECTORY_SEPARATOR . 'addresses.csv'; // '\addresses.csv'; //'addresses.csv'; //DATASETS . 'addresses.csv';
//    private const FOODS = DATASETS . DIRECTORY_SEPARATOR . 'foods.csv';
//    private const IMAGES = DATASETS . DIRECTORY_SEPARATOR . 'food_images';
//    private const FOOD_REVIEWS = DATASETS . DIRECTORY_SEPARATOR . 'food_reviews.csv';

    private const FIRSTNAMES = TESTING_DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv';
    private const LASTNAMES = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'lastnames.txt';
    private const ADDRESSES = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'addresses.csv';
    private const FOODS = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'foods.csv';
    private const IMAGES = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_images';

    private const FOOD_REVIEWS = TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_reviews.csv';


    public static function firstname (): string {
        $lines = file(self::FIRSTNAMES);
        $index = rand(1, count($lines) - 1);
        return trim(explode(',', $lines[$index])[0], ' ');
    }

    public static function lastname (): string {
        $lines = file(self::LASTNAMES);
        $index = rand(1, count($lines) - 1);
        return trim($lines[$index], ' ');
    }

    public static function imagePath (): string {
        $directory = '..\..\testing_datasets\food_images';
        $pictures = scandir(FOOD_IMAGES);
        $picture = $pictures[rand(2, count($pictures) - 1)];
//        $path = 'images' . DIRECTORY_SEPARATOR . $files[$index]; //FOOD_IMAGES . DIRECTORY_SEPARATOR . $files[$index];
//        echo 'image path:' . $path . '<br>' . PHP_EOL;
        $path = FOOD_IMAGES . DIRECTORY_SEPARATOR .  $picture; //. DIRECTORY_SEPARATOR . $picture;
        echo nl2br($path . PHP_EOL);
//        echo nl2br('pastriama\IMAGE PATH:' . $path . PHP_EOL);
        return $path;
        //return 'images' . DIRECTORY_SEPARATOR . $picture;  //$path; // FOOD_IMAGES . DIRECTORY_SEPARATOR . $files[$index];
    }

    public static function postalAddress (): PostalAddress {
        $lines = file(self::ADDRESSES);
        $fields = explode('\',\'', $lines[rand(1, count($lines) - 1)]);
        $number = explode(',\'', $fields[0])[1];
        $street = $number . ' ' . $fields[1];
        $city = trim($fields[2], ' \'');
        $state = State::from('Minnesota');
        $zipcode = new Zipcode($fields[3]);
        return new PostalAddress(SerialNumber::nextPostalAddressId(), $street, $city, $state, $zipcode);
    }

    public static function numeric (int $length=1, bool $ambiguous=false,): string {
        $string = '';
        $floor = 0;
        $ceiling = 9;
        if (!$ambiguous) {
            $floor = 2;
        }
        for ($index = 0; $index < abs($length); $index++) {
            $string .= rand(0, 9);
        }
        return $string;
    }

    public static function letters (int $length, bool $ambiguous = false): string {
        $string = '';
        $array = LETTERS;
        if (!$ambiguous) {
            $array = UNAMBIGUOUS_LETTERS;
        }
        for ($index = 0; $index < abs($length); $index++) {
            $index = array_rand($array, 1);
            $string .= $array[$index];
        }
        return $string;
    }

    public static function alphanumerics (int $length): string {
        $string = '';
        for ($index = 0; $index < abs($length); $index++) {
            $index = array_rand(ALPHA_NUMERICS, 1);
            $string .= ALPHA_NUMERICS[$index];
        }
        return $string;
    }

    public static function amount (int $floor, int $ceiling): float {
        return rand($floor, $ceiling) + 0.99;
    }

    public static function clockTime (int $minHour=0, int $maxHour=23): DateTime {
        $time = rand($minHour, $maxHour) . ':' . rand(0, 59) . '.' . rand(0, 59);
        return DateTime::createFromFormat('H:i s', $time);
    }

    public static function yearSelector (
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

    /**
     * @throws Exception
     */
    public static function someDateTime (DateTime $dateFloor, DateTime $dateCeiling): DateTime {
        $epochTime = $dateFloor->getTimestamp()
            + (int) rand(0, ($dateCeiling->getTimestamp() - $dateFloor->getTimeStamp()));
        return new DateTime("@$epochTime");
    }

    /**
     * @throws Exception
     */
    private static function getExtraChars (): string {
        $chars = '';
        $counter = 0;
        $charTotal = rand(0, 4);
        while ($counter < $charTotal) {
            $chars .= self::alphanumerics($charTotal);
            $counter++;
        }
        return sanitize_input(strtolower($chars));
    }

    /**
     * @throws Exception
     */
    public static function email (string $firstname, string $lastname): EmailAddress {
        $separator = trim(EMAIL_SEPARATORS[array_rand(EMAIL_SEPARATORS)]);
        $extraChars = trim(self::getExtraChars());
        $mailbox = trim(strtolower($firstname)) . trim($separator) . trim(strtolower($lastname)) . $extraChars;
        $index = array_rand(EMAIL_PROVIDERS);
        $fields = explode('.', EMAIL_PROVIDERS[array_rand(EMAIL_PROVIDERS)]);
        $name = trim(implode('.', array_slice($fields, 0, -1))); //$providerFields)
        $tld = trim($fields[count($fields) - 1], ' ');
//        $array = explode('.', EMAIL_PROVIDERS[$index]);
//        $name = trim(implode('.', array_slice($array, 0, -1)), ' ');
        $domain = new Domain($name, $tld);
//        echo '<br>domain:' . $domain . PHP_EOL . '<br>';
//        $domain = new Domain($name, $array[count($array) - 1]);
        return new EmailAddress($mailbox, $domain);
    }

    /**
     * @throws Exception
     */
    public static function phone (): Phone {
        $areaCode = self::numeric(1, true) . self::numeric(2,);
        $exchange = self::numeric(3);
        $lineNumber = self::numeric(4);
        return new Phone($areaCode, $exchange, $lineNumber);
    }

    /**
     * @throws Exception
     */
    public static function creditCard (string $nameOnCard): CreditCard {
        $dateFloor = DateTime::createFromFormat('Y-m-d', '2027-01-01');
        $dateCeiling = DateTime::createFromFormat('Y-m-d', '2029-01-01');
        $number = self::numeric(4) . ' ' . self::numeric(4)
            . ' ' . self::numeric(4) . ' ' . self::numeric(4);
        $expirationDate = self::someDateTime($dateFloor, $dateCeiling);
        $cvn = self::numeric(3);
        return new CreditCard(
            SerialNumber::nextCreditCardId(),
            CreditCardProvider::random(),
            $nameOnCard,
            $number,
            $expirationDate,
            $cvn
        );
    }

    /**
     * @throws Exception
     */
    public static function Pastry (): Pastry {
        $lines = file(self::FOODS);
        $tuple = explode(',', $lines[rand(2, count($lines) - 1)]);
        $name = trim($tuple[1], '"');
        $description = trim($tuple[2], '"');
        return new Pastry(
            SerialNumber::nexPastryId(),
            $name,
            $description,
            self::imagePath(),
            self::amount(self::MIN_PASTRY_PRICE, self::MAX_PASTRY_PRICE)
        );
    }

    /**
     * @throws Exception
     */
    public static function review (User $user, Pastry $pastry): Review {
        $lines = file(self::FOOD_REVIEWS);
        $tuple = explode(',', $lines[rand(2, count($lines) - 1)]);
//        $index = rand(2, count($lines) -1);
//        $data = explode(',', $lines[$index]);
//        print_r($data);
        $title = trim($tuple[0], '"');
        $content = trim($tuple[1], '"');
        return new Review(
            SerialNumber::nextReviewId(),
            $user,
            $pastry,
            rand(Review::MINIMUM_RATING, Review::MAXIMUM_RATING),
            $title,
            $content,
            self::someDateTime(
                TRANSACTION_DATE_FLOOR,
                DateTime::createFromFormat(DATE_FORMAT, date(DATE_FORMAT))
            )
        ); //$content['title'], $content['text']);
    }

    public static function password (): string {
        return 'p';
    }

//    public static function pickShippingAddress (User $user): PostalAddress {
//        $index = array_rand($user->getCreditCards()->getItems());
//        return $user->getShippingAddresses()->getItems()[$index];
//    }

    public static function pickCreditCard (User $user): CreditCard {
        $index = array_rand($user->getCreditCards()->getList());
        return $user->getCreditCards()->getList()[$index];
    }

    private static function pickPastry (Pastries $pastries): Pastry {
        return $pastries->getList()[array_rand($pastries->getList())];
    }

//    public static function (Products $products): Products {
//        $invoice = new Products();
//        $totalItems = rand(0, count($products->getList()));
//        for ($i = 0; $i < $totalItems; $i++) {
//            $invoice->addProduct($products->randomItem());
//        }
//        return $invoice;
//    }

    /**
     * @throws Exception
     */
    public static function user (): User {
        $firstname = self::firstname();
        $lastname = self::lastname();
        $currentDate = DateTime::createFromFormat(DATE_FORMAT, date(DATE_FORMAT));
        $birthdateFloor = $currentDate->sub(new \DateInterval('P80Y'));
        $birthdateCeiling = $currentDate->sub(new \DateInterval('P18Y'));
        $birthdate = self::someDateTime(BIRTHDATE_FLOOR, BIRTHDATE_CEILING);
//            DateTime::createFromFormat('Y-m-d', '1940-01-01'),
//            DateTime::createFromFormat('Y-m-d', '2006-01-01'),
//        );
        $phone = self::phone();
        $email = self::email($firstname, $lastname);
        $postalAddress = self::postalAddress();
        $creditCard = self::creditCard($firstname . ' ' . $lastname);
        $password = self::password();
        $user = new User(
            SerialNumber::nextUserId(),
            $firstname,
            $lastname,
            $birthdate,
            $phone,
            $email,
            $password,
            $postalAddress,
            $creditCard
        );
        $totalCards = 1 + rand(self::MIN_ADDITIONAL_CARDS, self::MAX_ADDITIONAL_CARDS);
        $counter = 1;
        while ($counter < $totalCards) {
            $user->getCreditCards()->addCard(self::creditCard($firstname . ' ' . $lastname));
            $counter++;
        }
        $extraAddressCount = rand(0, self::MAX_SHIPPING_ADDRESSES);
        $counter = 0;
        while($counter < $extraAddressCount) {
            $address = self::postalAddress();
//            echo 'got ' .  $counter . ' address ' . $address . '<br>' . PHP_EOL;
            $user->getShippingAddresses()->add($address); //self::postalAddress());
            $counter++;
        }
        return $user;
    }

    /**
     * @throws Exception
     */
    public static function order (User $user): ?Order {
        if (count($user->getShoppingCart()->getList()) > 0) {
            $order = new Order(
                SerialNumber::nextOrderId(),
                $user,
                self::pickCreditCard($user),
                $user->printName(),
                $user->getShippingAddresses()->randomAddress(),
                self::someDateTime(TRANSACTION_DATE_FLOOR, new DateTime())
            );
            $user->getShoppingCart()->emptyToTarget($order->getInvoice());
            return $order;
        }
        return null;
    }

//    /**
//     * @throws Exception
//     */
//    public static function order (User $user, Pastries $pastries): Order {
//        $submissionTime = self::someDateTime(
//            DateTime::createFromFormat('Y-m-d', '2020-01-01'),
//            new DateTime()
//        );
//        $order = new Order(
//            SerialNumber::nextOrderId(),
//            $user,
//            self::pickCreditCard($user),
//            $user->printName(),
//            $user->getPostalAddress(), //self::pickShippingAddress($user),
//            $submissionTime
//        );
//        for ($i = 0; $i < rand(self::MIN_INVOICE_SIZE, self::MAX_INVOICE_SIZE); $i++) {
//            $order->getInvoice()->add(
//                new Product(
//                    self::pickPastry($pastries),
//                    rand(self::MINIMUM_ITEM_QUANTITY, self::MAXIMUM_ITEM_QUANTITY)
//                ));
//        }
//        return $order;
//    }
}