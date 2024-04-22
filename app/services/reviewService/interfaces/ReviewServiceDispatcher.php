<?php

namespace app\services\reviewService\interfaces;

use app\services\reviewService\messages\collections\ReviewServiceQueries;
use app\services\reviewService\messages\ReviewServerResponse;
use app\services\reviewService\messages\ReviewServiceQuery;

interface ReviewServiceDispatcher {

    public function getId ();
    public function getRequestQueue (): ReviewServiceQueries;

    public function forwardAnswer (): void;
    public function forwardServiceQuery (): void;
    public function receiveServerResponse (ReviewServerResponse $response): void;
    public function receiveServiceQuery (ReviewServiceQuery $query): void;

}