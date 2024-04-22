<?php

namespace app\interfaces;

use app\enums\Status;

interface Disable {
    public function getStatus (): Status;

    public function setStatus (Status $status): void;

    public function cascadeStatusUpdate (): bool;
}