<?php declare(strict_types=1);

namespace app\service\responses;

use app\models\concretes\User;
use app\models\lists\Users;
use app\models\singletons\UsersCatalog;
use app\service\requests\LoginRequest;
use app\service\requests\RegisterAccountRequest;
use app\utils\SerialNumber;
use Exception;

class Response {

    public function __construct () {}

    /**
     * @throws Exception
     */
    public static function login (Users $users, LoginRequest $request): User {
        $user = $users->searchByEmail($request->getEmail());
        if (is_null($user)) {
            throw new Exception('There is no user with email ' . $request->getEmail());
        }
        if ($user->getPassword() != $request->getPassword()) {
            throw new Exception('incorrect password');
        }
//        $usersCatalog = UsersCatalog::getInstance();
//        $userA = $usersCatalog->getUsers()->searchByEmail($request->getEmail());
//        if (is_null($userA) || $userA->getPassword() != $request->getPassword())  {
//            throw new Exception('No matching entry for ' . $request->getEmail() . ' inside the usersCatalog');
//        }
        return $user;
    }

    /**
     * @throws Exception
     */
    public function registerAccount (Users $users, RegisterAccountRequest $request): User {
        $user = new User (
            SerialNumber::nextUserId(),
            $request->getFirstname(),
            $request->getLastname(),
            $request->getBirthdate(),
            $request->getPhone(),
            $request->getEmailAddress(),
            $request->getPassword(),
            $request->getPostalAddress(),
            $request->getCreditCard()
        );
//        $usersCatalog = UsersCatalog::getInstance();
//        $usersCatalog->getUsers()->add($user);
        $users->add($user);
        return $user;
    }


}