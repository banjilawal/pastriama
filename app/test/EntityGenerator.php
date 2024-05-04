<?php declare(strict_types=1);

namespace app\test;

//require_once '..\..\testing_datasets\pictures'; //'..\..\testing_datasets\pictures';

use app\enums\DataCategory;
use app\enums\Rating;
use app\models\abstracts\Product;
use app\models\concretes\Order;
use app\models\concretes\User;
use app\models\concretes\Pastry;
use app\models\concretes\review;
use app\utils\SerialNumber;

use DateInterval;
use DateTime;
use Exception;

//define ("BIRTHDATE_FLOOR", DateTime::createFromFormat('Y-m-d', '1940-01-01'));
//define ("BIRTHDATE_CEILING", DateTime::createFromFormat('Y-m-d', '2006-01-01'));
//define ('TRANSACTION_DATE_FLOOR', DateTime::createFromFormat('Y-m-d', '2020-01-01'));
//define ('PICTURES_PATH', '..\..\testing_datasets\pictures');
//
//define ('MINIMUM_CREDIT_CARDS', 1);
//define ('MAXIMUM_CREDIT_CARDS', 6);
//
//define ('MINIMUM_ADDRESSES', 1);
//define ('MAXIMUM_ADDRESSES', 4);


class EntityGenerator {

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
    public static function product (): Product {
        $fields = Create::randData(DataCategory::FOOD);
        return new Pastry(
            SerialNumber::nexPastryId(),
            explode(':', explode('||', $fields)[0])[1],
            explode(':', explode('||', $fields)[1])[1],
            Create::randData(DataCategory::FOOD_PICTURE),
            Create::price(LOWEST_PRICE, HIGHEST_PRICE)
        );
    }

    /**
     * @throws Exception
     */
    public static function review (User $user, Product $product): review {
        $fields = Create::randData(DataCategory::FOOD_REVIEW);
        return new review(
            SerialNumber::nextReviewId(),
            $user,
            $product,
            Rating::cases()[array_rand(Rating::cases())],
            explode(':', explode('||', $fields)[0])[1],
            explode(':', explode('||', $fields)[1])[1],
            Create::someDateTime((new DateTime())->sub(new DateInterval('P4Y')), new DateTime())
        );
    }

    /**
     * @throws Exception
     */
    public static function user (): User {
        $firstname = Create::randData(DataCategory::FIRSTNAME);
        $lastname = Create::randData(DataCategory::LASTNAME);
        $user = new User(
            SerialNumber::nextUserId(),
            $firstname,
            $lastname,
            Create::birthdate(),
            Create::phone(),
            Create::email($firstname, $lastname),
            Create::password(),
            Create::postalAddress(),
            Create::creditCard($firstname . ' ' . $lastname)
        );
        $totalCards = 1 + rand(MINIMUM_CREDIT_CARDS, MAXIMUM_CREDIT_CARDS);
        for ($i = MINIMUM_CREDIT_CARDS; $i < $totalCards; $i++) {
            $user->getCreditCards()->add(Create::creditCard($firstname . ' ' . $lastname));
        }
        $totalAddresses = rand(MINIMUM_ADDRESSES, MAXIMUM_ADDRESSES);
        for ($i = MINIMUM_ADDRESSES; $i < $totalAddresses; $i++) {
            $user->getAddresses()->add(Create::postalAddress());
        }
        return $user;
    }

    /**
     * @throws Exception
     */
    public static function order (User $user): ?Order {
        $order = null;
        $productCount = rand(0, count($user->getCart()->getItems()));
        for ($i = 0; $i < $productCount; $i++) {
            $item = $user->getCart()->random();
            $itemQuantity = rand(0, (int) ($item->getQuantity() / 3));
            if ($itemQuantity > 0) {
                $order = new Order(
                    SerialNumber::nextOrderId(),
                    $user,
                    $user->getCreditCards()->random(),
                    $user->printName(),
                    $user->getAddresses()->random(),
                    Create::someDateTime(((new DateTime())->sub(new DateInterval('P5Y'))), new DateTime())
                );
                $order->add($item->getProduct(), $itemQuantity);
                echo nl2br( $order . PHP_EOL
                     . 'product_count:' . $productCount . ' item_quantity:' . $itemQuantity
                    . ' ' . $item->getProduct()->getName()
                    . ' ORDER===>' .  $order .PHP_EOL
                );
            }
        }
        return $order;
    }

}