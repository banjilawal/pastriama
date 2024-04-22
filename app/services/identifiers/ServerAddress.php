<?php

namespace app\services\identifiers;

use AllowDynamicProperties;
use app\enums\HostType;
use app\enums\Service;
use app\interfaces\Equality;

class ServerAddress extends HostAddress {

    public function __construct (Service $service, int $id) {
        parent::__construct($service, HostType::SERVER, $id);

    }
}