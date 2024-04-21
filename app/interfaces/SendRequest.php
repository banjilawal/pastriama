<?php

namespace app\interfaces;

use app\services\Service;

interface SendRequest {
    public function send (): Request;
}