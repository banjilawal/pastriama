<?php

namespace app\interfaces\review;

use app\servers\ReviewServer\ReviewServerReply;
use app\services\review\ReviewClientRequest;

interface ReviewServer {
    public function send (): ReviewServerReply;

    public function receive (ReviewClientRequest $request): void;

    public function serverForwardRequest (ReviewDispatch $dispatcher, ReviewServerReply $reply): void;
}