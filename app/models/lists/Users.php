<?php

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\EmailAddress;
use app\models\concretes\User;
use Exception;

class Users extends Model {
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
    public function addUsers (Users $users): void {
        foreach ($users as $user) {
            $this->add($user);
        }
    }

    /**
     * @throws Exception
     */
    public function add (User $user): void {
        if (array_key_exists($user->getId(), $this->list)) {
            throw new Exception($user->getId() . ' is already in the list');
        }
        if (!is_null($this->searchByEmail($user->getEmailAddress()))) {
           throw new Exception('A user with email ' . $user->getEmailAddress() . ' already exists. Adding user operations failed');
        }
        $this->list[$user->getId()] = $user;
    }

    /**
     * @throws Exception
     */
    public function removeUsers (Users $users): void {
        foreach ($users as $id => $user) {
            $this->remove($user);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (User $user): void {
        $id = $user->getId();
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($user->getEmailAddress()
                . ' does not exist in the list. Cannot remove nonexistent user named ' . $user->getName());
        }
        unset($this->list[$id]);
    }

    public function searchByEmail (EmailAddress $email): ?User {
        foreach ($this->list as $user) {
//            echo nl2br('testing if ' . $user->printName() . ' has email ' . $email . PHP_EOL);
            if ($user->getEmailAddress()->equals($email) === true) { //__toString() === $email->__toString()) {
                echo nl2br($user->printName() . ' has email ' . $email . PHP_EOL);
                return $user;
            }
        }
        return null;
    }

    public function searchById (int $id): ?User {
        foreach ($this->list as $user) {
            if ($user->getId() === $id)
                return $user;
        }
        return null;
    }

    public function toTable (): string {
        $elem ='<table id="usersTable">'
            . '<thead>'
            . '<tr>'
            . '<th>Name</th>'
            . '<th>Email</th>'
            . '<th>Phone</th>'
            . '<th>Mailing Address</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->list as $id => $user) {
            $elem .= $this->list[$id]->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}