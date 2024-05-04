<?php

namespace app\interfaces\adapters;

use app\models\concretes\Email;

interface GetEmail {
    public function getEmail (): Email;
}