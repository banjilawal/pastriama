<?php

namespace app\test;

//define('MAXIMUM_EXTRA_CHARS', 4);
//define ('FIRSTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv');
//define ('LASTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'lastnames.txt');
//define ('ADDRESSES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'addresses.csv');
//define ('FOODS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'foods.csv');
//define ('IMAGES', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'pictures');
//define ('FOOD_REVIEWS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_reviews.csv');
public const IN_TRANSIT_MESSAGE = 'Your order is in transit';


use app\enums\CreditCardProvider;
use app\enums\DataCategory;
use app\enums\State;
use app\models\concretes\CreditCard;
use app\models\concretes\Domain;
use app\models\concretes\Email;
use app\models\concretes\Phone;
use app\models\concretes\PostalAddress;
use app\models\concretes\Zipcode;
use DateInterval;
use DateTime;
use Exception;

class Create {


    /**
     * @throws Exception
     */
    public static function randData (DataCategory $category): string {
        $lines = null;
        switch ($category) {
            case DataCategory::FOOD_PICTURE:
                $pictures = scandir(FOOD_IMAGES);
                $picture = $pictures[rand(2, count($pictures) - 1)];
                return imagePath() . DIRECTORY_SEPARATOR . $pictures[array_rand($pictures)];
                break;
            case DataCategory::FIRSTNAME:
                $lines = file(FIRSTNAMES);
                return trim(explode(',', $lines[array_rand($lines)])[0]);
                break;
            case DataCategory::LASTNAME:
                $lines = file(LASTNAMES);
                return trim($lines[array_rand($lines)]);
                break;
            case DataCategory::FOOD:
                $lines = file(FOODS);
                $fields = explode(',', $lines[array_rand($lines)]);
//                foreach ($fields as $field) {
//                    echo $field . PHP_EOL;
//                }
                $name = trim($fields[1], '"');
                $description = trim($fields[2], '"');
                $string = 'name:' . $name . '||decription:' . $description;
                return $string;
                break;
            case DataCategory::FOOD_REVIEW:
                $lines = file(FOOD_REVIEWS);
                $fields = explode(',', $lines[array_rand($lines)]);
                $title = trim($fields[0], '"');
                $comment = trim($fields[1], '"');
                return 'title:' . $title . '||comment:' . $comment;
                break;
            default:
                throw new Exception('invalid name category');
        }
    }

    public static function password (): string {
        return 'p';
    }
    public static function price (int $floor, int $ceiling): float {
        return rand($floor, $ceiling) + 0.99;
    }

    private static function domain (): Domain {
        $fields = explode('.', EMAIL_PROVIDERS[array_rand(EMAIL_PROVIDERS)]);
        $name = trim(implode('.', array_slice($fields, 0, -1)));
        $tld = trim($fields[count($fields) - 1], ' ');
        return new Domain($name, $tld);
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
    public static function birthdate (): DateTime {
        $floor = (new DateTime())->sub(new DateInterval('P95Y'));
        $ceiling = (new DateTime())->sub(new DateInterval('P18Y'));
        return self::someDateTime($floor, $ceiling);
    }


    /**
     * @throws Exception
     */
    public static function email (string $firstname, string $lastname): Email {
        $separator = sanitize_input(EMAIL_SEPARATORS[array_rand(EMAIL_SEPARATORS)]);
        $extraChars = sanitize_input(strtolower(Util::alphanumerics(rand(0, EMAIL_MAXIMUM_EXTRA_CHARS))));
        $mailbox = trim(strtolower($firstname)) . $separator . trim(strtolower($lastname)) . $extraChars;
        return new Email($mailbox, self::domain());
    }

    /**
     * @throws Exception
     */
    public static function phone (): Phone {
        $areaCode = Util::numeric(1, true) . Util::numeric(2,);
        $exchange = Util::numeric(3);
        $lineNumber = Util::numeric(4);
        return new Phone($areaCode, $exchange, $lineNumber);
    }

    /**
     * @throws Exception
     */
    public static function creditCard (string $nameOnCard): CreditCard {
        $dateFloor = (new DateTime())->sub(new DateInterval('P3Y'));
        $dateCeiling = $dateFloor->add(new DateInterval('P5Y'));
        $number = Util::numeric(4) . ' ' . Util::numeric(4)
            . ' ' . Util::numeric(4) . ' ' . Util::numeric(4);
        return new CreditCard(
            SerialNumber::nextCreditCardId(),
            CreditCardProvider::random(),
            $nameOnCard,
            $number,
            self::someDateTime($dateFloor, $dateCeiling),
            Util::numeric(3)
        );
    }

    /**
     * @throws Exception
     */
    public static function postalAddress (): PostalAddress {
        $lines = file(ADDRESSES);
        $fields = explode('\',\'', $lines[array_rand($lines)]);
        $number = trim('\'',explode(',', $fields[0])[2]);
        $street = $number . ' ' . $fields[1];
        $city = trim($fields[2], ' \'');
        $state = State::MINNESOTA;
        $zipcode = new Zipcode($fields[3]);
        return new PostalAddress(SerialNumber::nextPostalAddressId(), $street, $city, $state, $zipcode);
    }
}