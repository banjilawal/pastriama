<?php

namespace app\templates;

use app\models\abstracts\StoreItem;
use app\models\collections\CreditCards;

class HTMLSelector {

    public static function quantity ():string {
        $elem = '<label for ="quantity">Quantity to Order</label>'
            . '<select id="quantity" name="quantity" required>';
        for ($i = 1; $i <= MAX_QUANTITY_PER_ORDER; $i++) {
            $elem .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }

    public function creditCard (CreditCards $cards): string {
        $elem = '<label for ="creditCard">Credit Card</label><select id="creditCard" name="creditCard" required>'
            . '<option value="'. $this->list[0] . '" selected>'
            . $this->list[0]->securelyPrintCardNumber . '</option>';
        for ($i = 1; $i < count($this->list); $i++) {
            $elem .= '<option value="' . $this->list[$i] . '">' . $this->list[$i]->securelyPrintCardNumber . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }

}