<?php declare(strict_types=1);

namespace app\dispatchers;

use app\interfaces\review\ReviewClient;
use app\interfaces\review\ReviewServer;
use app\interfaces\review\ReviewDispatch;

use SplQueue;

class ReviewDispatcher implements ReviewDispatch {

    private SplQueue $clients;
    private array $servers;

    public function __construct () {
        $this->clients = new SplQueue();
        $this->servers = array();
    }

    public function getClients (): ReviewClient|SplQueue {
        return $this->clients;
    }

    public function getServers (): ReviewServer|array {
        return $this->servers;
    }
}