<?php declare(strict_types=1);

namespace app\test;

use app\models\concretes\CreditCard;
use app\models\concretes\Domain;
use app\models\concretes\EmailAddress;
use app\models\concretes\Order;
use app\models\concretes\InvoiceItem;
use app\models\concretes\Pastry;
use app\models\concretes\Phone;
use app\models\concretes\PostalAddress;
use app\models\concretes\Review;
use app\models\concretes\State;
use app\models\concretes\User;
use app\models\concretes\Zipcode;
use app\models\lists\Pastries;
use app\utils\SerialNumber;
use DateTime;
use Exception;

class EntityGenerator {
    protected static int $userId = 0;
    protected static int $creditCardId = 0;
    private const MAX_ID = 65536; // PHP_INT_MAX
    private const MAX_SHIPPING_ADDRESSES = 2;
    private const MIN_PASTRY_PRICE = 1;
    private const MAX_PASTRY_PRICE = 3;

    private const MIN_INVOICE_SIZE = 0;
    private const MAX_INVOICE_SIZE = 10;
    private const MIN_ADDITIONAL_CARDS = 0;
    private const MAX_ADDITIONAL_CARDS = 5;
    private const MINIMUM_ITEM_QUANTITY = 1;
    private const MAXIMUM_ITEM_QUANTITY = 24;

    private const FIRSTNAMES = DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv'; //DATASETS . '\lastnames.txt';
    private const LASTNAMES = DATASETS . DIRECTORY_SEPARATOR . 'lastnames.txt'; //DATASETS . '\firstnames.csv';
    private const ADDRESSES = DATASETS . DIRECTORY_SEPARATOR . 'addresses.csv'; // '\addresses.csv'; //'addresses.csv'; //DATASETS . 'addresses.csv';
    private const FOODS = DATASETS . DIRECTORY_SEPARATOR . 'foods.csv';
    private const FOOD_REVIEWS = DATASETS . DIRECTORY_SEPARATOR . 'food_reviews.csv';

    public const CREDIT_CARD_VENDORS = ['Mastercard', 'Visa', 'American Express', 'Discover'];

    public static function id (): int {
        return rand(1, self::MAX_ID - 1);
    }

    public function getId() {
        return $this->id;
    }
    public static function nextUserId (): int {
        self::$userId++;
        return self::$userId;
    }

    public static function nextCreditCardId (): int {
        self::$creditCardId++;
        return self::$creditCardId;
    }

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
        $pictures = scandir(FOOD_IMAGES);
//        print_r($files);
//        $index = rand(2, count($files) - 1);
        $picture = $pictures[rand(2, count($pictures) - 1)];
//        $path = 'images' . DIRECTORY_SEPARATOR . $files[$index]; //FOOD_IMAGES . DIRECTORY_SEPARATOR . $files[$index];
//        echo 'image path:' . $path . '<br>' . PHP_EOL;
        return 'images' . DIRECTORY_SEPARATOR . $picture;  //$path; // FOOD_IMAGES . DIRECTORY_SEPARATOR . $files[$index];
    }

    public static function postalAddress (): PostalAddress {
        $lines = file(self::ADDRESSES);
//        $index= rand(1, count($lines) - 1);
        $fields = explode('\',\'', $lines[rand(1, count($lines) - 1)]); //$index]);
//        print_r($fields) . '<br>' . PHP_EOL;
        $number = explode(',\'', $fields[0])[1];
//        $number = (explode(',\'', $fields[0]))[1];
//        print_r($number) . '<br>' . PHP_EOL;
//        echo $number;
//        echo 'number:' .$number . '<br>' . PHP_EOL;
        $street = $number . ' ' . $fields[1];
//        echo 'street:' . $street . PHP_EOL . '<br>';
        $city = trim($fields[2], ' \'');
        $state = new State('MN');
        $zipcode = new Zipcode($fields[3]);
//        $address = new PostalAddress($street, $city, $state, $zipcode);
//        echo $address->getStreet() . PHP_EOL . '<br>';
//        echo 'postal address:' .$address . PHP_EOL . '<br>';
        return new PostalAddress($street, $city, $state, $zipcode);
    }

    /**
     * @throws Exception
     */
    public static function numeric (int $length = 1, bool $ambiguous = false,): string {
        if ($length < 1) {
            throw new Exception('Desired string length of ' . $length . ' is outside the acceptable range');
        }
        $string = '';
        $floor = 0;
        $ceiling = 9;
        if (!$ambiguous) {
            $floor = 2;
        }
        for ($index = 0; $index < $length; $index++) {
            $string .= rand(0, 9);
        }
        return $string;
    }

    /**
     * @throws Exception
     */
    public static function letters (int $length, bool $ambiguous = false): string {
        if ($length < 1) {
            throw new Exception('Desired string length of ' . $length . ' is outside the acceptable range');
        }
        $string = '';
        $array = LETTERS;
        if (!$ambiguous) {
            $array = UNAMBIGUOUS_LETTERS;
        }
        for ($index = 0; $index < $length; $index++) {
            $index = array_rand($array, 1);
            $string .= $array[$index];
        }
        return $string;
    }

    /**
     * @throws Exception
     */
    public static function alphanumerics (int $length): string {
        if ($length < 1) {
            throw new Exception('Desired string length of ' . $length . ' is outside the acceptable range');
        }
        $string = '';
        for ($index = 0; $index < $length; $index++) {
            $index = array_rand(ALPHA_NUMERICS, 1);
            $string .= ALPHA_NUMERICS[$index];
        }
        return $string;
    }

    public static function amount (int $floor, int $ceiling): float {
        return rand($floor, $ceiling) + 0.99; //$floor + mt_rand() / mt_getrandmax() * ($ceiling - $floor);
    }

    public static function clockTime (int $minHour = 0, int $maxHour = 23): DateTime {
        $time = rand($minHour, $maxHour) . ':' . rand(0, 59)
            . '.' . rand(0, 59);
        return DateTime::createFromFormat('H:i s', $time);
    }

    /**
     * @throws Exception
     */
    public static function someDateTime (DateTime $floor, DateTime $ceiling): DateTime {
//        $floorTimestamp = $floor->getTimestamp();
//        $maxSeconds = $ceiling->getTimestamp() - $floor->getTimeStamp(); // ($ceiling->getTimestamp() - $floor->getTimestamp()) / (60 * 60 * 24);
//        $interval = (int) rand(0, $maxSeconds);
//        $epochTime = $floorTimestamp + $interval; //($actualSeconds * 60 * 60 * 24);
        $epochTime = $floor->getTimestamp() + (int) rand(0, ($ceiling->getTimestamp() - $floor->getTimeStamp()));
//        return new DateTime("@epochTime");
        $dateTime = new DateTime("@$epochTime");
//        echo nl2br(
//            'floor:' . $floor->format('Y-m-d')
//            . 'ceiling:' . $ceiling->format('Y-m-d')
//            . 'floor seconds: ' . $floorTimestamp
//            . ' ceiling seconds:' . $ceiling->getTimestamp()
//            . ' max seconds:' . $maxSeconds
//            . ' actual seconds:' . $interval
//            . ' unixTime:' . $epochTime
//            . ' date picked:' . $dateTime->format('Y-m-d')
//            . PHP_EOL
//        );
        return $dateTime;
//        $dateTime = DateTime::createFromFormat('U', $unixTime);
//        echo 'unixTime: ' . $unixTime . ' ISO time:' .  $dateTime->format('Y-m-d H:i:s');
//        return (new DateTime())->setTimestamp($unixTime);// ::createFromFormat('U', $unixTime); //$dateTime;
    }

//    /**
//     * @throws Exception
//     */
//    public static function imageFile (): string {
//            $files = array_diff(scandir(ASSETS), ['.', '..']);
//            if (empty($files)) {
//                throw new Exception('Cannot select a jpg file ' . ASSETS . ' directory is empty.');
//            }
//            $index = array_rand($files);
//            return $files[$index];
//    }

    /**
     * @throws Exception
     */
    private static function getExtraChars (): string {
        $chars = '';
        $counter = 0;
        $charTotal = rand(0, 4);
//        echo PHP_EOL . '<br>' .  'number of extras:' . $charTotal . PHP_EOL . '<br>';
        while ($counter < $charTotal) {
            $chars .= self::alphanumerics($charTotal);
            $counter++;
        }
        return strtolower(trim($chars));
    }

    /**
     * @throws Exception
     */
    public static function email (string $firstname, string $lastname): EmailAddress {
        $separator = trim(EMAIL_SEPARATORS[array_rand(EMAIL_SEPARATORS)]);
        $extraChars = trim(self::getExtraChars());

//        echo PHP_EOL . '<br>' . 'email separator:' . $separator . PHP_EOL . '<br>';
//        echo 'extra characters:' . $extraChars . PHP_EOL . '<br>';
        $mailbox = trim(strtolower($firstname)) . trim($separator) . trim(strtolower($lastname)) . $extraChars;
//        echo ' mailbox:' . $mailbox;


//        if ((mt_rand() / mt_getrandmax()) > 0.5) {
//            $mailbox = strtolower($lastname) . $separator . strtolower($firstname);
//        }
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
        $vendor = CreditCard::CREDIT_CARD_VENDORS[array_rand(CreditCard::CREDIT_CARD_VENDORS)];
        $number = self::numeric(4)
            . ' ' . self::numeric(4)
            . ' ' . self::numeric(4)
            . ' ' . self::numeric(4);
        $expirationDate = self::someDateTime(
            DateTime::createFromFormat('Y-m-d', '2027-01-01'),
            DateTime::createFromFormat('Y-m-d', '2029-01-01'),
        );
        $cvn = self::numeric(3);
        return new CreditCard(
            SerialNumber::nextCreditCardId(),
            $vendor,
            $nameOnCard,
            $number,
            $expirationDate,
            $cvn
        );
    }

    public static function pastry (): Pastry {
        $lines = file(self::FOODS);
        $tuple = explode(',', $lines[rand(2, count($lines) - 1)]);
//        $data = explode(',', $line);
//        $id = (int) number_format($data[0]);
        $name = trim($tuple[1], '"');
        $description = trim($tuple[2], '"');
        return new Pastry(
            SerialNumber::nexPastryId(),
            $name, //self::pastryName(),
            $description, // self::foodDescription(), //'this is some food',
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
//        $content[1] = trim($content[1], ' "');
//        return array('title' => $title, 'content' => $content);
//        $content = self::reviewContent();
//        $rating = 3;
        return new Review(
            SerialNumber::nextReviewId(),
            $user,
            $pastry,
            rand(Review::MINIMUM_RATING, Review::MAXIMUM_RATING),
            $title,
            $content,
            self::someDateTime(
                DateTime::createFromFormat('Y-m-d', '2020-01-01'),
                new DateTime()
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
        $index = array_rand($user->getCreditCards()->getItems());
        return $user->getCreditCards()->getItems()[$index];
    }

    private static function pickPastry (Pastries $pastries): Pastry {
        return $pastries->getItems()[array_rand($pastries->getItems())];
    }

    /**
     * @throws Exception
     * @throws Exception
     */
    public static function user (): User {
        $firstname = self::firstname();
        $lastname = self::lastname();
        $birthdate = self::someDateTime(
            DateTime::createFromFormat('Y-m-d', '1940-01-01'),
            DateTime::createFromFormat('Y-m-d', '2006-01-01'),
        );
        $phone = self::phone();
        $email = self::email($firstname, $lastname);
        $postalAddress = self::postalAddress();
        $creditCard = self::creditCard($firstname . ' ' . $lastname);
        $password = self::password();
        $user = new User(
            self::nextUserId(),
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
            $user->getCreditCards()->add(self::creditCard($firstname . ' ' . $lastname));
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
    public static function order (User $user, Pastries $pastries): Order {
        $submissionTime = self::someDateTime(
            DateTime::createFromFormat('Y-m-d', '2020-01-01'),
            new DateTime()
        );
        $order = new Order(
            SerialNumber::nextOrderId(),
            $user,
            self::pickCreditCard($user),
            $user->printName(),
            $user->getPostalAddress(), //self::pickShippingAddress($user),
            $submissionTime
        );
        for ($i = 0; $i < rand(self::MIN_INVOICE_SIZE, self::MAX_INVOICE_SIZE); $i++) {
            $order->getInvoice()->add(
                new InvoiceItem(
                    self::pickPastry($pastries),
                    rand(self::MINIMUM_ITEM_QUANTITY, self::MAXIMUM_ITEM_QUANTITY)
                ));
        }
        return $order;
    }
}