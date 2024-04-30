<?php

namespace app\models\collections;

use app\models\abstracts\Model;
use app\models\concretes\EmailAddress;
use app\models\concretes\NewUser;
use Exception;

class NewUsers extends Model {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): NewUser|array {
        return $this->list;
    }


    /**
     * @throws Exception
     */
    public function add (NewUser $user): void {
        $id = $user->getId();
        if (array_key_exists($user->getId(), $this->list)) {
            throw new Exception($user->getId() . ' is already in the list');
        }
        if (!is_null($this->searchByEmail($user->getEmailAddress()))) {
           throw new Exception('Cannot grant the request. ' . $user->getEmailAddress() . ' is in use.');
        }
        $this->list[$user->getId()] = $user;
    }


    /**
     * @throws Exception
     */
    public function remove (NewUser $user): void {
        $id = $user->getId();
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($user->getEmailAddress()
                . ' does not exist in the list. Cannot remove nonexistent NewUser named ' . $user->getName());
        }
        unset($this->list[$id]);
    }

    public function searchByEmail (EmailAddress $email): ?NewUser {
        foreach ($this->list as $user) {
            if ($user->getEmailAddress()->equals($email) === true) { return $user; }
        }
        return null;
    }

    public function searchById (int $id): ?NewUser {
        if (array_key_exists($id, $this->list))
            return $this->list[$id];
        return null;
    }

    public function contains (NewUser $target): bool {
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

    public function randomUser (): NewUser {
        return $this->list[array_rand($this->list)];
    }
}