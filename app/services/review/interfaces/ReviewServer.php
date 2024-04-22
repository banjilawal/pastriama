<?php

namespace app\services\review\interfaces;

use app\services\identifiers\ServerAddress;
use app\services\review\messages\client\ReviewServiceQuery;
use app\services\review\messages\server\ReviewServerResponse;

interface ReviewServer {

    public function equals (Object $object): bool;
    public function getAddress (): ServerAddress;
    public function sendResponse (): ReviewServerResponse;
    public function getQuery (ReviewServiceQuery $query): void;




}