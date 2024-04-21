<?php

namespace app\clients;

use app\interfaces\ReceiveReply;
use app\interfaces\SendRequest;

abstract class Client implements SendRequest, ReceiveReply {
}