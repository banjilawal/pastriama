<?php declare(strict_types=1);

namespace app\templates;

use app\enums\ListTag;
use app\enums\Orientation;
use app\enums\StylingClass;
use app\models\catalogs\Inventory;
use app\models\collections\Addresses;
use app\models\collections\CreditCards;
use app\models\collections\Reviews;
use app\models\collections\Reviews;
use app\models\concretes\InventoryItem;
use app\models\concretes\User;
use app\models\concretes\User;
use app\utils\Create;

class HTMLList {

//    private static function openingTag (StylingClass $listStyling=StylingClass::INTERACTIVE_LIST): string {
//        return '<div ' . StylingClass::CONTAINER->value . ' ">'
//            . '<ul "' . $listStyling->value . '">';
//    }

    public static function shoppingCart (User $user): string {
        $elem = '<ol>';
        foreach ($user->getCart()->getItems() as $id => $item) {
            $saveCheckbox = Create::addCheckbox('Save for later', ('saveProduct_' . $id), ' ' . $id, '');
            $deleteButton = Create::addButton('Remove from your shopping cart', ('deleteProduct_' . $id), '' . $id);
            $controls = Create::addList(ListTag::UNORDERED, [$saveCheckbox, $deleteButton]);
            echo $item;
            $elem .= '<li><div>' . $controls . '</div><div>' . $item . '</div></li>';
        }
        return Create::addDivTag(($elem . '</ol>'), StylingClass::SHOPPING_CART);
    }

    public static function inventory (Inventory $inventory): string {
        $elem = '';
        foreach ($inventory->getItems() as $id => $item) {
            $elem .= '<li ' . StylingClass::NONE->value . ' id="' . $id . '" onclick="rowClickHandler(' . $id . ')">'
                . Create::addDivTag(
                   ('' . $item->getProduct()->getImgTag()
                        . ' ' .$item->getProduct()->getName()
                        . ' ' . $item->getProduct()->getDescription()
                        . ' ' . number_format($item->getProduct()->getPrice(), 2)
                    ),
                     StylingClass::DIV_ROW)
                . '</li>';
        }
        return Create::addDivTag(($elem . '</ul>'), StylingClass::NONE);
    }

    public static function creditCards (CreditCards $cards): string {
        $elem = '<ul>';
        $size = count($cards->getList());
        foreach ($cards->getList() as $id => $card) {
            $primaryButton = '';
            $deleteCheckbox = Create::addCheckbox('Delete Card', ('deleteCard_' . $id), 'delelte', 'delete', Orientation::RIGHT,);
//            $buttonId = 'primaryCard_' . $id;
//            $checkboxId = 'deleteCard_' . $id;
            if ($size > 1) {
                $primaryButton  = Create::addRadioButton('Mark as Primary', ('primaryCard_' . $id), 'primaryCreditCard', ' ' . $id, '');
//                $innerHTML = Create::addRadioButton(
//                    'Mark as Primary', //'primaryCreditCard',
//                    $buttonId,
//                    'primaryCreditCard',
//                    $id,
//                    Create::addCheckbox('Delete Card', $checkboxId, $id, $card, Orientation::LEFT),
//                );
            }
                $controls = Create::addList(ListTag::UNORDERED, [$primaryButton, $deleteCheckbox]);
                $elem .= '<li><div>' . $controls . '</div><div>' . $card . '</div></li>';
//            else { $innerHTML = Create::addCheckbox('Delete Card', $checkboxId, $id, $card, Orientation::LEFT); }
            $elem .= '</ul>';
        }
        return Create::addDivTag($elem, StylingClass::CONTAINER);
    }

    public static function addresses (Addresses $addresses): string {
        $elem = '<ul>';
        foreach ($addresses->getList() as $id => $address) {
            $buttonId = 'deleteAddress_' . $id;
            $elem .= Create::addRadioButton('Delete', $buttonId, 'deleteAddress', $id, $address);
        }
        $elem .= '</ul>';
        return Create::addDivTag($elem, StylingClass::CONTAINER);
    }

    public static function reviews (Reviews $reviews): string {
        $elem = '';
        foreach ($reviews->getList() as $id => $review) {
            $elem .= '<li ' . StylingClass::NONE->value . ' id="' . $id . '" onclick="rowClickHandler(' . $id . ')">'
                . Dashboard::review($review) . '</li>';
        }
        return Create::addDivTag(($elem . '</ul>'), StylingClass::NONE);
    }
}