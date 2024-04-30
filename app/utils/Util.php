<?php

namespace app\utils;

//define('MAXIMUM_EXTRA_CHARS', 4);
//define ('FIRSTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv');
//define ('LASTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'lastnames.txt');
//define ('ADDRESSES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'addresses.csv');
//define ('FOODS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'foods.csv');
//define ('IMAGES', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_images');
//define ('FOOD_REVIEWS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_reviews.csv');

use app\enums\CreditCardProvider;
use app\enums\ListTag;
use app\enums\DataCategory;
use app\enums\Orientation;
use app\enums\State;
use app\enums\StylingClass;
use app\models\concretes\CreditCard;
use app\models\concretes\Domain;
use app\models\concretes\EmailAddress;
use app\models\concretes\Phone;
use app\models\concretes\PostalAddress;
use app\models\concretes\Zipcode;
use DateInterval;
use DateTime;
use Exception;

class Util {

    /**
     * @throws Exception
     */
    public static function randData (DataCategory $category): string {
        $lines = null;
        switch ($category) {
            case DataCategory::FOOD_PICTURE:
                $pictures = scandir(FOOD_IMAGES);
                $picture = $pictures[rand(2, count($pictures) - 1)];
                return $pictures[array_rand($pictures)];
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

    public static function numeric (int $length=1, bool $ambiguous=false,): string {
        $string = '';
        $floor = 0;
        if (!$ambiguous) {
            $floor = 2;
        }
        for ($index = 0; $index < abs($length); $index++) {
            $string .= rand($floor, 9);
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

    public static function price (int $floor, int $ceiling): float {
        return rand($floor, $ceiling) + 0.99;
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
        $floor = (new DateTime())->sub(new \DateInterval('P95Y'));
        $ceiling = (new DateTime())->sub(new \DateInterval('P18Y'));
//        echo nl2br(PHP_EOL . 'CURRENT=' . $currentDate->format(DATE_FORMAT)
//            . ' DATE_FLOOR=' . $floor->format(DATE_FORMAT)
//            . ' DATE_CEILING=' . $ceiling->format(DATE_FORMAT) . PHP_EOL);
        return self::someDateTime($floor, $ceiling);
    }

    /**
     * @throws Exception
     */
    private static function extraChars (int $maxChars=EMAIL_MAXIMUM_EXTRA_CHARS): string {
        $chars = '';
        $counter = 0;
        $charTotal = rand(0, 4);
        while ($counter < $charTotal) {
            $chars .= self::alphanumerics($charTotal);
            $counter++;
        }
        return sanitize_input(strtolower(self::alphanumerics(rand(0, $maxChars))));
    }

    /**
     * @throws Exception
     */
    public static function email (string $firstname, string $lastname): EmailAddress {
        $separator = sanitize_input(EMAIL_SEPARATORS[array_rand(EMAIL_SEPARATORS)]);
        $extraChars = sanitize_input(strtolower(self::alphanumerics(rand(0, EMAIL_MAXIMUM_EXTRA_CHARS))));
        $mailbox = trim(strtolower($firstname)) . $separator . trim(strtolower($lastname)) . $extraChars;
        $fields = explode('.', EMAIL_PROVIDERS[array_rand(EMAIL_PROVIDERS)]);
        $name = trim(implode('.', array_slice($fields, 0, -1)));
        $tld = trim($fields[count($fields) - 1], ' ');
        $domain = new Domain($name, $tld);
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
        $dateFloor = (new DateTime())->sub(new DateInterval('P3Y'));
        $dateCeiling = $dateFloor->add(new DateInterval('P5Y'));
        $number = self::numeric(4) . ' ' . self::numeric(4)
            . ' ' . self::numeric(4) . ' ' . self::numeric(4);
        return new CreditCard(
            SerialNumber::nextCreditCardId(),
            CreditCardProvider::random(),
            $nameOnCard,
            $number,
            self::someDateTime($dateFloor, $dateCeiling),
            self::numeric(3)
        );
    }

    public static function postalAddress (): PostalAddress {
        $lines = file(ADDRESSES);
        $fields = explode('\',\'', $lines[array_rand($lines)]);
        $number = explode(',\'', $fields[0])[1];
        $street = $number . ' ' . $fields[1];
        $city = trim($fields[2], ' \'');
        $state = State::MINNESOTA;
        $zipcode = new Zipcode($fields[3]);
        return new PostalAddress(SerialNumber::nextPostalAddressId(), $street, $city, $state, $zipcode);
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

    public static function password (): string {
        return 'p';
    }

    public static function orientElement (
        string $center,
        string $element,
        Orientation $orientation=Orientation::RIGHT
    ): string {
        return match ($orientation) {
            Orientation::LEFT => $element . '&nbsp;' . $center,
            Orientation::RIGHT => $center . '&nbsp;' . $element,
            Orientation::TOP => $element . '<br>' . $center,
            default => $center . '<br' . $element,
        };
    }

    public static function addCheckbox (
        string $labelText,
        string $checkboxId,
        string $checkboxValue,
        string $text,
        Orientation  $textOrientation= Orientation::RIGHT,
        StylingClass $class=StylingClass::NONE
    ): string {
        $checkbox = '<label for ' . $checkboxId . '>' . $labelText . '</label>'
            . '<input type="checkbox" ' . $class->value . ' id="' . $checkboxId . '"'
            . ' name="' . $checkboxId . '"'
            . ' value="' . $checkboxValue . '"> ';
        return self::orientElement($checkbox, $text, $textOrientation);
//        switch ($textOrientation) {
//            case Orientation::LEFT:
//                return $text . '&nbsp;' . $checkbox;
//            case Orientation::RIGHT:
//                return $checkbox . '&nbsp;' . $text;
//            case Orientation::TOP:
//                return $text . '<br>' . $checkbox;
//            default:
//                return $checkbox . '<br' . $text;
//        }
    }

    public static function addList (ListTag $listTag, string|array $items, StylingClass $class=StylingClass::NONE): string {
        $elem = '<' . $listTag->value . ' ' . $class->value . '>';
        foreach ($items as $item) {
            $elem .= '<li>' . $item . '</li>';
        }
        return $elem . '</' . $listTag->value . '>';
    }

    public static function addRadioButton (
        string $labelText,
        string $radioButtonId,
        string $radioButtonGroup,
        string $radioButtonValue,
        string $text,
        Orientation  $textOrientation= Orientation::RIGHT,
        StylingClass $class=StylingClass::NONE
    ): string {
        $radioButton = '<label for ' . $radioButtonGroup . '>' . $labelText . '</label>'
            . '<input type="checkbox" ' . $class->value . ' id="' . $radioButtonId . '"'
            . ' name="' . $radioButtonGroup . '"'
            . ' value="' . $radioButtonValue . '">';
        return self::orientElement($radioButton, $text, $textOrientation);
    }

    public static function addButton (
        string $labelText,
        string $buttonId,
        string $buttonValue,
        StylingClass $class=StylingClass::NONE
    ): string {
        return '<label for ' . $buttonId . '>' . $labelText . '</label>'
            . '<input type="button" ' . $class->value . ' id=" ' . $buttonId . '"'
            . ' name="' . $buttonId . '"'
            . ' value="' . $buttonValue . '">';
    }

    public static function addDivTag (
        string $innerHTML,
        StylingClass $stylingClass=StylingClass::NONE
    ): string {
        return '<div ' . $stylingClass->value . ' ">' . $innerHTML . '</div>';
    }

    public static function addListItem (
        string $innerHTML,
        StylingClass $stylingClass=StylingClass::NONE
    ): string {
        return '<li ' . $stylingClass->value . '>' . $innerHTML . '</li>';
    }

    public static function dashboardMember (
        string $innerHTML,
        StylingClass $stylingClass=StylingClass::DASHBOARD_MEMBER
    ): string {
        return '<div ' . StylingClass::DASHBOARD_MEMBER->value . '>' . $innerHTML . '</div>';
    }

    public static function dashboardSection (
        string $heading,
        string $innerHTML,
        int $headingLevel=3,
        StylingClass $stylingClass=StylingClass::DASHBOARD_MEMBER
    ): string {
        return '<div ' . $stylingClass->value . '>'
            . '<h' . $headingLevel . '>'. $heading . '</' . $headingLevel . '>'
            . $innerHTML . '</div>';
    }

    public static function dashboard (
        string $heading,
        string $innerHTML,
        int $headingLevel=1,
        StylingClass $stylingClass=StylingClass::DASHBOARD_CONTAINER
    ): string {
        return '<div ' . $stylingClass->value . '>'
            . '<h' . $headingLevel . '>'. $heading . '</' . $headingLevel . '>'
            . $innerHTML . '</div>';
    }

    public static function addLink (
        string $file,
        string $text,
        StylingClass $stylingClass=StylingClass::NONE
    ): string {
        return '<a href="' . $file . '" ' . $stylingClass->value . '>' . $text . '</a>';
    }
}