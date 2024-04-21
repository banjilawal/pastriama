<?php declare(strict_types=1);

namespace app\dispatchers;

use app\interfaces\Dispatch;
use app\interfaces\Reply;
use app\interfaces\Request;

class Dispatcher implements Dispatch {

    public function forwardRequest (Server $server): Request {
        // TODO: Implement forwardRequest() method.
    }

    public function forwardReply (Client $client): Reply {
        // TODO: Implement forwardReply() method.
    }


}