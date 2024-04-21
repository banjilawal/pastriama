<?php

namespace app\servers;

use app\interfaces\ReceiveRequest;
use app\interfaces\SendReply;

abstract class Server implements SendReply, ReceiveRequest {
}