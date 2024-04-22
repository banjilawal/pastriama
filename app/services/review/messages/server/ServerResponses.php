<?php declare(strict_types=1);

namespace app\services\review\messages\server;

use app\services\identifiers\ServerReplyIdentifier;
use app\services\review\messages\client\ReviewServiceQuery;
use Exception;

class ServerResponses {
    private array $list;

    public function __construct () {
        $this->list = array();
    }

    public function getList (): ReviewServerResponse|array {
        return $this->list;
    }


    /**
     * @throws Exception
     */
    public function add (ReviewServerResponse $response): void {
        if ($this->contains($response)) {
            throw new Exception($response->getResponseId() . ' is already in the list');
        }
        $this->list[] = $response;
    }

    /**
     * @throws Exception
     */
    public function remove (ReviewServerResponse $response): void {
        $index = $this->getIndex($response);
        if ($index === PHP_INT_MIN) {
            throw new Exception('message:' . $response->getResponseId() . ' not found. Reply remove failed');
        }
        unset($this->list[$index]);

    }

    public function searchByResponseId (ServerReplyIdentifier $responseId): ?ReviewServerResponse {
        foreach ($this->list as $response) {
            if ($response->responseId()->equals($responseId))
                return $response;
        }
        return null;
    }

    public function searchByQuery (ReviewServiceQuery $query): ?ReviewServerResponse {
        foreach ($this->list as $response) {
            if ($response->getQuery()->equals($query)) { return $response; }
        }
        return null;
    }

    public function contains (ReviewServerResponse $target): bool {
        foreach ($this->list as $response) {
            if ($response->equals($target))
                return true;
        }
        return false;
    }

    public function getIndex (ReviewServerResponse $response): int {
        for ($i = 0; $i < count($this->list); $i++) {
            if ($this->list[$i]->equals($response))
                return $i;
        }
        return PHP_INT_MIN;
    }
}