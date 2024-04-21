<?php

namespace app\requests;

use app\interfaces\Client;
use app\interfaces\Dispatch;
use app\interfaces\Request;

class Requestor implements Request {
    private Client $client;
    private Dispatch $dispatcher;

    /**
     * @param Client $client
     * @param Dispatch $dispatcher
     */
    public function __construct (Client $client, Dispatch $dispatcher) {
        $this->client = $client;
        $this->dispatcher = $dispatcher;
    }

    public function getClient (): Client {
        return $this->client;
    }

    public function getDispatcher (): Dispatch {
        return $this->dispatcher;
    }

    public function send (Dispatch $dispatch): void {
        // TODO: Implement send() method.
    }
}