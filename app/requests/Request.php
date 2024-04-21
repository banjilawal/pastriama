<?php

namespace app\requests;

use app\clients\Client;
use app\services\Service;

abstract class Request {

//    private Client $client;
//    private Service $service;
//
//    /**
//     * @param Service $service
//     */
//    public function __construct (Client $client, Service $service)  {
//        $this->client = $client;
//        $this->service = $service;
//    }
//
//    public function getClient (): Client {
//        return $this->client;
//    }
//
//    public function getService (): Service {
//        return $this->service;
//    }
    public abstract function getClient (): Client;
    public abstract function getService (): Service;
}