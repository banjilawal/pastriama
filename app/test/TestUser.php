<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\User;
use DateTime;
use Exception;

class TestUser {
    private const MIN_ADDITIONAL_CARDS = 0;
    private const MAX_ADDITIONAL_CARDS = 5;

//    private int $userId;
//    private int $creditCardId;

  //  private static $instance  = null;

//    public function __construct(int $userId, int $creditCardId) {
//        $this->userId = $userId;
//        $this->creditCardId = $creditCardId;
//    }

//    public function __clone(){}
//
//    public function __wakeup(){}

//    public static function getInstance (): TestUser {
//        if (self::$instance === null) {
//            $instance = new TestUser();
//        }
//        return self::$instance;
//    }

    /**
     * @throws Exception
     */
    public static function createUser () : User {
        $firstname = EntityGenerator::firstname();
//        echo 'firstname:' . $firstname;
        $lastname = EntityGenerator::lastname();
//        echo $lastname;
//        echo ' lastname:' . $lastname;
        $birthdate = EntityGenerator::someDateTime(
            DateTime::createFromFormat('Y-m-d', '1940-01-01'),
            DateTime::createFromFormat('Y-m-d', '2006-01-01'),
        );
        $phone = EntityGenerator::phone();
        $email = EntityGenerator::email($firstname, $lastname);
//        echo ' email:' . $email;
        $postalAddress = EntityGenerator::postalAddress();
        $creditCard = EntityGenerator::creditCard(EntityGenerator::id());
        $password = EntityGenerator::password();
        $user = new User(
            EntityGenerator::id(),
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
            $creditCard = EntityGenerator::creditCard(EntityGenerator::id());
            $user->getCreditCards()->add($creditCard);
            $counter++;
        }
        return $user;
    }
}