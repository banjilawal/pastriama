<?php

namespace app\interfaces;

use app\services\Service;

interface Request {
       public function request (): Service;
}