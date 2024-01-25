<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\CreditCard;
use app\models\concretes\User;
use DateTime;
use Exception;
use RandomPrimitive;

class RandomUserBuilder {
    private const MIN_ADDITIONAL_CARDS = 0;
    private const MAX_ADDITIONAL_CARDS = 5;

    private int $userId;
    private int $creditCardId;

  //  private static $instance  = null;



    public function __construct(int $userId, int $creditCardId) {
        $this->userId = $userId;
        $this->creditCardId = $creditCardId;
    }

    public function __clone(){}

    public function __wakeup(){}

//    public static function getInstance (): RandomUserBuilder {
//        if (self::$instance === null) {
//            $instance = new RandomUserBuilder();
//        }
//        return self::$instance;
//    }

    /**
     * @throws Exception
     */
    public function createUser (): User {
        $firstname = RandomPrimitive::firstname();
//        echo 'firstname:' . $firstname;
        $lastname = RandomPrimitive::lastname();
//        echo $lastname;
//        echo ' lastname:' . $lastname;
        $birthdate = RandomPrimitive::someDateTime(
            DateTime::createFromFormat('Y-m-d', '1940-01-01'),
            DateTime::createFromFormat('Y-m-d', '2006-01-01'),
        );
        $phone = RandomPrimitive::phone();
        $email = RandomPrimitive::email($firstname, $lastname);
//        echo ' email:' . $email;
        $postalAddress = RandomPrimitive::postalAddress();
        $creditCard = RandomPrimitive::creditCard($this->creditCardId);
        $password = RandomPrimitive::password();
        $user = new User(
            $this->userId,
            $firstname,
            $lastname,
            $birthdate,
            $phone,
            $email,
            $password,
            $postalAddress,
            $creditCard
        );

        $totalCards = 1 + rand(self::MIN_ADDITIONAL_CARDS, self::MAX_ADDITIONAL_CARDS);
        $counter = 1;
        while ($counter < $totalCards) {
            $creditCard = RandomPrimitive::creditCard(RandomPrimitive::id());
            $user->getCreditCards()->add($creditCard);
            $counter++;
        }
        return $user;
    }
}