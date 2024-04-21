<?php declare(strict_types=1);

namespace app\services\review;

use app\interfaces\review\ReviewClient;
use SplQueue;

class ReviewClients {
    private SplQueue  $queue;


    public function __construct ($list) {
        $this->queue = new SplQueue();
    }

    public function getQueue (): ReviewClient|SplQueue {
        return $this->queue;
    }
}