<?php

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\User;
use Exception;

class UserList extends Model {
    private array $items;


    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): User|array {
        return $this->items;
    }

    /**
     * @throws Exception
     */
    public function addUsers (UserList $users): void {
        foreach ($users as $id => $user) {
            $this->add($user);
        }
    }

    /**
     * @throws Exception
     */
    public function add (User $user): void {
        if (array_key_exists($user->getId(), $this->items)) {
            throw new Exception($user->getId() . ' is already in the list');
        }
        if (!is_null($this->searchByEmail($user->getEmail()))) {
           throw new Exception('A user with email ' . $user->getEmail() . ' already exists. Adding user operations failed');
        }
        $this->items[$user->getId()] = $user;
    }

    /**
     * @throws Exception
     */
    public function removePUsers (UserList $users): void {
        foreach ($users as $id => $user) {
            $this->remove($user);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (User $user): void {
        $id = $user->getId();
        if (!array_key_exists($id, $this->items)) {
            throw new Exception($user->getEmail() . ' does not exist in the list. Cannot remove nonexistent user named ' . $user->getName());
        }
        unset($this->items[$id]);
    }

    public function searchByEmail (string $email): ?User {
        foreach ($this->items as $user) {
            if ($user->getEmail() === $email)
                return $user;
        }
        return null;
    }

    public function searchById (int $id): ?User {
        foreach ($this->items as $user) {
            if ($user->getId() === $id)
                return $user;
        }
        return null;
    }

    public function toTable (): string {
        $elem ='<table class="user-table" id="user-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Name</th>'
            . '<th>Email</th>'
            . '<th>Phone</th>'
            . '<th>Mailing Address</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $id => $user) {
            $elem .= $this->items[$id]->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}