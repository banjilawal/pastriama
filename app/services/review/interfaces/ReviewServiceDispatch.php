<?php

namespace app\services\review\interfaces;

use app\services\review\messages\client\ReviewServiceQueries;
use app\services\review\messages\client\ReviewServiceQuery;
use app\services\review\messages\server\ReviewServerResponse;

interface ReviewServiceDispatch {

    public function getId ();
    public function getRequestQueue (): ReviewServiceQueries;

    public function forwardAnswer (): void;
    public function forwardServiceQuery (): void;
    public function receiveServerResponse (ReviewServerResponse $response): void;
    public function receiveServiceQuery (ReviewServiceQuery $query): void;

}