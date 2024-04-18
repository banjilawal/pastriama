<?php

namespace app\enums;

enum Month: int {
    case JANUARY = 1;
    case FEBRUARY = 2;
    case MARCH = 3;
    case APRIL = 4;

    case MAY = 5;
    case JUNE = 6;
    case JULY = 7;
    case AUGUST = 8;
    case SEPTEMBER = 9;
    case OCTOBER = 10;
    case NOVEMBER = 11;
    case DECEMBER = 12;

    public function name (): string {
        return match ($this) {
            Month::JANUARY => 'January',
            Month::FEBRUARY => 'February',
            Month::MARCH => 'March',
            Month::APRIL => 'April',
            Month::MAY => 'May',
            Month::JUNE => 'June',
            Month::JULY => 'July',
            Month::AUGUST => 'August',
            Month::SEPTEMBER => 'September',
            Month::OCTOBER => 'October',
            Month::NOVEMBER => 'November',
            Month::DECEMBER => 'December',
        };
    }

    public static function selector (string $label='month'): string {
        $elem = '<label for="' . $label . '"></label>'
            . '<select id="' . $label . '" name="' . $label . '" required>';
        foreach (Month::cases() as $month) {
            $elem .= '<option value"' . $month->value . '">' . $month->name(). '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }

}