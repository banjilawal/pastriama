<?php declare(strict_types=1);

namespace app\service\responses;

use app\models\concretes\User;
use app\models\lists\Users;
use app\service\requests\LoginRequest;
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
        return $user;
    }
}