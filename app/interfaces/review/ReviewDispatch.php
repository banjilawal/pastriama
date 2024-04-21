<?php

namespace app\interfaces\review;

use app\requests\reviews\GetReviewsRequest;
use app\servers\ReviewServer\ReviewServerReply;
use app\services\review\ReviewClientRequest;

interface ReviewDispatch {
    public function forwardRequest (ReviewServer $server): ReviewClientRequest;

    public function forwardReply (ReviewClient $client): ReviewServerReply;

    public function receiveRequest (ReviewClientRequest $request) :void;

    public function receiveReply (ReviewServerReply $reply): void;

    public function serverForwardRequest (ReviewDispatch $dispatcher, ReviewServerReply $reply): void;
}