<?php declare(strict_types=1);

namespace app\templates;

use app\enums\ListTag;
use app\enums\StylingClass;
use app\models\catalogs\NewInventory;
use app\models\collections\Addresses;
use app\models\collections\CreditCards;
use app\models\collections\Reviews;
use app\models\concretes\InventoryItem;
use app\models\concretes\User;
use app\utils\Util;

class HTMLList {

//    private static function openingTag (StylingClass $listStyling=StylingClass::INTERACTIVE_LIST): string {
//        return '<div ' . StylingClass::CONTAINER->value . ' ">'
//            . '<ul "' . $listStyling->value . '">';
//    }

    public static function shoppingCart (User $user): string {
        $elem = '<ol>';
        foreach ($user->getShoppingCart()->getList() as $id => $item) {
            $saveCheckbox = Util::addCheckbox('Save for later', ('saveProduct_' . $id), $id, '');
            $deleteButton = Util::addButton('Remove from your shopping cart', ('deleteProduct_' . $id), $id);
            $controls = Util::addList(ListTag::UNORDERED, [$saveCheckbox, $deleteButton]);
            $elem .= '<li><div>' . $controls . '</div><div>' . Dashboard::pastry($item->getPastry()) . '</div></li>';
        }
        return Util::addDivTag(($elem . '</ol>'), StylingClass::SHOPPING_CART);
    }

    public static function inventory (NewInventory $inventory): string {
        $elem = '';
        foreach ($inventory->getItems() as $id => $item) {
            $elem .= '<li ' . StylingClass::NONE->value . ' id="' . $id . '" onclick="rowClickHandler(' . $id . ')">'
                . Util::addDivTag(
                   ('' . $item->getProduct()->getImgTag()
                        . ' ' .$item->getProduct()->getName()
                        . ' ' . $item->getProduct()->getDescription()
                        . ' ' . number_format($item->getProduct()->getPrice(), 2)
                    ),
                     StylingClass::DIV_ROW)
                . '</li>';
        }
        return Util::addDivTag(($elem . '</ul>'), StylingClass::NONE);
    }

    public static function creditCards (CreditCards $cards): string {
        $elem = '<ul>';
        $size = count($cards->getList());
        foreach ($cards->getList() as $id => $card) {
            $primaryButton = '';
            $deleteCheckbox = Util::addCheckbox('Delete Card', ('deleteCard_' . $id), $id,'');
//            $buttonId = 'primaryCard_' . $id;
//            $checkboxId = 'deleteCard_' . $id;
            if ($size > 1) {
                $primaryButton  = Util::addRadioButton('Mark as Primary', ('primaryCard_' . $id), 'primaryCreditCard', $id, '');
//                $innerHTML = Util::addRadioButton(
//                    'Mark as Primary', //'primaryCreditCard',
//                    $buttonId,
//                    'primaryCreditCard',
//                    $id,
//                    Util::addCheckbox('Delete Card', $checkboxId, $id, $card, Orientation::LEFT),
//                );
            }
                $controls = Util::addList(ListTag::UNORDERED, [$primaryButton, $deleteCheckbox]);
                $elem .= '<li><div>' . $controls . '</div><div>' . $card . '</div></li>';
//            else { $innerHTML = Util::addCheckbox('Delete Card', $checkboxId, $id, $card, Orientation::LEFT); }
            $elem .= '</ul>';
        }
        return Util::addDivTag($elem, StylingClass::CONTAINER);
    }

    public static function addresses (Addresses $addresses): string {
        $elem = '<ul>';
        foreach ($addresses->getList() as $id => $address) {
            $buttonId = 'deleteAddress_' . $id;
            $elem .= Util::addRadioButton('Delete', $buttonId, 'deleteAddress', $id, $address);
        }
        $elem .= '</ul>';
        return Util::addDivTag($elem, StylingClass::CONTAINER);
    }

    public static function reviews (Reviews $reviews): string {
        $elem = '';
        foreach ($reviews->getList() as $id => $review) {
            $elem .= '<li ' . StylingClass::NONE->value . ' id="' . $id . '" onclick="rowClickHandler(' . $id . ')">'
                . Dashboard::review($review) . '</li>';
        }
        return Util::addDivTag(($elem . '</ul>'), StylingClass::NONE);
    }
}