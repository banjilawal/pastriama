<?php

namespace app\services;

abstract class Service {
    private Response $response;

    /**
     * @param Response $response
     */
    public function __construct (Response $response) {
        $this->response = $response;
    }

    public function getResponse (): Response {
        return $this->response;
    }

    public function setResponse (Response $response): void {
        $this->response = $response;
    }
}