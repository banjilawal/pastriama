<?php

namespace app\utils;

//define('MAXIMUM_EXTRA_CHARS', 4);
//define ('FIRSTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'firstnames.csv');
//define ('LASTNAMES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'lastnames.txt');
//define ('ADDRESSES', TESTING_DATASETS . DIRECTORY_SEPARATOR . 'addresses.csv');
//define ('FOODS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'foods.csv');
//define ('IMAGES', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'pictures');
//define ('FOOD_REVIEWS', TESTING_DATASETS. DIRECTORY_SEPARATOR . 'food_reviews.csv');
public const IN_TRANSIT_MESSAGE = 'Your order is in transit';


use app\enums\CreditCardProvider;
use app\enums\ListTag;
use app\enums\DataCategory;
use app\enums\Orientation;
use app\enums\State;
use app\enums\StylingClass;
use app\models\concretes\CreditCard;
use app\models\concretes\Domain;
use app\models\concretes\Email;
use app\models\concretes\Phone;
use app\models\concretes\PostalAddress;
use app\models\concretes\Zipcode;
use DateInterval;
use DateTime;
use Exception;

class Util {


    public static function deliveryDateHandler (DateTime $deliveryDate): string {
        if ($deliveryDate <= new DateTime())
            return 'Delivered on ' . $deliveryDate->Format(DATE_TIME_FORMAT);
        else
            return IN_TRANSIT_MESSAGE;
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
        int $headingLevel=6,
        StylingClass $stylingClass=StylingClass::DASHBOARD_MEMBER
    ): string {
        return '<div ' . $stylingClass->value . '>'
            . '<h' . $headingLevel . '>'. $heading . '</' . $headingLevel . '><p>'
            . $innerHTML . '</p></div>';
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