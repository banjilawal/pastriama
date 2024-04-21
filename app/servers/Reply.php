<?php

namespace app\servers;

use app\responses\Response;

abstract class Reply {
    private Server $server;
    private Response $response;

    /**
     * @param Server $server
     * @param Response $response
     */
    public function __construct (Server $server, Response $response) {
        $this->server = $server;
        $this->response = $response;
    }

    public function getServer (): Server {
        return $this->server;
    }

    public function getResponse (): Response {
        return $this->response;
    }
}