<?php

namespace app\interfaces\adapters;

use app\models\concretes\User;

interface GetUser {
    public function getUser (): User;
}