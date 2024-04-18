<?php

namespace app\interfaces;

use app\models\concretes\User;

interface Renderable {
    public function body (): string;

    public function getPage (): string;
}