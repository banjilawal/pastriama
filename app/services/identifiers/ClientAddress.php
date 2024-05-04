<?php

namespace app\services\identifiers;

use app\enums\HostType;
use app\enums\Service;

class ClientAddress extends HostAddress {

    public function __construct (Service $service, int $id) {
        parent::__construct($service, HostType::CLIENT, $id);

    }
}