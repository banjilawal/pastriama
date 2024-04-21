<?php

namespace app\interfaces\review;

use app\servers\ReviewServer\ReviewServerReply;
use app\services\review\ReviewClientRequest;

interface ReviewClient {
    public function send (): ReviewClientRequest;
    public function receive (): ReviewServerReply;

}