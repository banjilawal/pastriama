<?php

namespace app\models\collections;

use app\models\abstracts\Aggregation;
use app\models\abstracts\Model;
use app\models\concretes\Email;
use app\models\concretes\User;
use Exception;

class Users extends Aggregation {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): User|array {
        return $this->list;
    }


    /**
     * @throws Exception
     */
    public function add (User $user): void {
        $id = $user->getId();
//        if (array_key_exists($user->getId(), $this->list)) {
//            throw new Exception($user->getId() . ' is already in the list');
//        }
//        if (!is_null($this->searchByEmail($user->getEmail()))) {
//           throw new Exception('Cannot grant the request. ' . $user->getEmail() . ' is in use.');
//        }
        $this->list[$user->getId()] = $user;
    }


    /**
     * @throws Exception
     */
    public function remove (User $user): void {
        $id = $user->getId();
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($user->getEmail()
                . ' does not exist in the list. Cannot remove nonexistent User named ' . $user->getName());
        }
        unset($this->list[$id]);
    }

    public function searchByEmail (Email $email): ?User {
        $user = null;
        foreach ($this->list as $user) {
//            echo $user->getEmail()->__toString() . ' ==  '.  $email->__toString();
//            if ($user->getEmail()->__toString() === $email->__toString()) {
                return $user;
            } //->equals($email) === true) { return $user; }
            return $user;
//        }
    }

    public function searchById (int $id): ?User {
        if (array_key_exists($id, $this->list))
            return $this->list[$id];
        return null;
    }

    public function matchLogin (Email $email, string $password): ?User {
        echo nl2br($email . '||||' . $password . PHP_EOL);
        foreach ($this->list as $id => $user) {
            echo nl2br($user->getEmail() . ' and ' . $user->getPassword() . PHP_EOL);
            if ($user->getEmail()->equals($email) && $user->getPassword() === $password) {
                return $this->list[$user->getId()];
            }
        }
        return null;
    }

    public function contains (User $target): bool {
        foreach ($this->list as $id => $user) {
            if ($user->equals($target))
                return true;
        }
        return false;
    }

    public function __toString (): string {
        $string = 'Users' . PHP_EOL;
        foreach ($this->list as $user) {
            $string .= $user . PHP_EOL;
        }
        return $string;
    }

    public function random (): User {
        return $this->list[array_rand($this->list)];
    }
}