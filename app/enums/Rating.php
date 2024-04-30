<?php

namespace app\enums;

enum Rating: int {
    case TERRIBLE = 1;
    case POOR = 2;
    case AVERAGE = 3;
    case GOOD = 4;
    case EXCELLENT = 5;

    public static function selector (): string {
        $elem = '<label for="rating">Rating</label>'
            . '<select id="cardProvider" name="cardProvider" required>';
        foreach (Rating::cases() as $rating) {
            $elem .= '<option value"' . $rating->value . '">' . $rating->name . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}