<?php declare(strict_types=1);

namespace app\test;

//require_once '..\..\testing_datasets\food_images'; //'..\..\testing_datasets\food_images';

use app\enums\DataCategory;
use app\enums\Rating;
use app\models\abstracts\Product;
use app\models\concretes\NewOrder;
use app\models\concretes\NewUser;
use app\models\concretes\Pastry;

use app\models\concretes\NewReview;
use app\models\concretes\User;


use app\utils\SerialNumber;
use app\utils\Util;

use DateInterval;
use DateTime;
use Exception;

//define ("BIRTHDATE_FLOOR", DateTime::createFromFormat('Y-m-d', '1940-01-01'));
//define ("BIRTHDATE_CEILING", DateTime::createFromFormat('Y-m-d', '2006-01-01'));
//define ('TRANSACTION_DATE_FLOOR', DateTime::createFromFormat('Y-m-d', '2020-01-01'));
//define ('PICTURES_PATH', '..\..\testing_datasets\food_images');
//
//define ('MINIMUM_CREDIT_CARDS', 1);
//define ('MAXIMUM_CREDIT_CARDS', 6);
//
//define ('MINIMUM_ADDRESSES', 1);
//define ('MAXIMUM_ADDRESSES', 4);


class NewEntityGenerator {

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
    public static function Pastry (): Pastry {
        $fields = Util::randData(DataCategory::FOOD);
        return new Pastry(
            SerialNumber::nexPastryId(),
            explode(':', explode('||', $fields)[0])[1],
            explode(':', explode('||', $fields)[1])[1],
            Util::randData(DataCategory::FOOD_PICTURE),
            Util::price(LOWEST_PRICE, HIGHEST_PRICE)
        );
    }

    /**
     * @throws Exception
     */
    public static function product (): Product {
        $fields = Util::randData(DataCategory::FOOD);
        return new Pastry(
            SerialNumber::nexPastryId(),
            explode(':', explode('||', $fields)[0])[1],
            explode(':', explode('||', $fields)[1])[1],
            Util::randData(DataCategory::FOOD_PICTURE),
            Util::price(LOWEST_PRICE, HIGHEST_PRICE)
        );
    }

    /**
     * @throws Exception
     */
    public static function review (NewUser $user, Product $product): NewReview {
        $fields = Util::randData(DataCategory::FOOD_REVIEW);
//        echo nl2br($user->printName() . ' is creating review of ' . $product->getName() . PHP_EOL);
//        $submitTime = Util::someDateTime((new DateTime())->sub(new DateInterval('P4Y')), new DateTime());
//        $rating = Rating::cases()[array_rand(Rating::cases())];
//        $title = explode(':', explode('||', $fields)[0])[1];
//        $comment = explode(':', explode('||', $fields)[1])[1];
//        echo nl2br(
//            'NewEntityGenerator_REVIEW Product::==>' . $product
//            . ' SUBMIT_TIME:' . $submitTime->format(DATE_FORMAT)
//            . 'RATING:' . $rating->name
//            . 'TITLE:' . $title . PHP_EOL
//        );
        return new NewReview(
            SerialNumber::nextReviewId(),
            $user,
            $product,
            Rating::cases()[array_rand(Rating::cases())],
            explode(':', explode('||', $fields)[0])[1],
            explode(':', explode('||', $fields)[1])[1],
            Util::someDateTime((new DateTime())->sub(new DateInterval('P4Y')), new DateTime())
        );
    }

    /**
     * @throws Exception
     */
    public static function user (): NewUser {
        $firstname = Util::randData(DataCategory::FIRSTNAME);
        $lastname = Util::randData(DataCategory::LASTNAME);
        $user = new NewUser(
            SerialNumber::nextUserId(),
            $firstname,
            $lastname,
            Util::birthdate(),
            Util::phone(),
            Util::email($firstname, $lastname),
            Util::password(),
            Util::postalAddress(),
            Util::creditCard($firstname . ' ' . $lastname)
        );
        $totalCards = 1 + rand(MINIMUM_CREDIT_CARDS, MAXIMUM_CREDIT_CARDS);
        for ($i = MINIMUM_CREDIT_CARDS; $i < $totalCards; $i++) {
            $user->getCreditCards()->addCard(Util::creditCard($firstname . ' ' . $lastname));
        }
        $totalAddresses = rand(MINIMUM_ADDRESSES, MAXIMUM_ADDRESSES);
        for ($i = MINIMUM_ADDRESSES; $i < $totalAddresses; $i++) {
            $user->getAddresses()->add(Util::postalAddress());
        }
        return $user;
    }

    /**
     * @throws Exception
     */
    public static function order (NewUser $user): ?NewOrder {
        $order = null;
        $productCount = rand(0, count($user->getCart()->getItems()));
        for ($i = 0; $i < $productCount; $i++) {
            $item = $user->getCart()->getItems()[array_rand($user->getCart()->getItems())];
            $itemQuantity = rand(0, (int) ($item->getQuantity() / 3));
            if ($itemQuantity > 0) {
                $order = new NewOrder(
                    SerialNumber::nextOrderId(),
                    $user,
                    $user->getCreditCards()->randomCreditCard(),
                    $user->printName(),
                    $user->getAddresses()->randomAddress(),
                    Util::someDateTime(((new DateTime())->sub(new \DateInterval('P5Y'))), new DateTime())
                );
                $order->add($item->getProduct(), $itemQuantity);
                echo nl2br( $order . PHP_EOL
//                    PHP_EOL . 'product_count:' . $productCount . ' item_quantity:' . $itemQuantity
//                    . ' ' . $item->getProduct()->getName()
//                    . ' ORDER===>' .  $order .PHP_EOL
                );
            }
        }
        return $order;
    }

}