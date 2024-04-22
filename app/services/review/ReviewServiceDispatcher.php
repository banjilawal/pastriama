<?php

namespace app\services\review;

use app\interfaces\Identifiable;
use app\services\lists\ClientAddressList;
use app\services\lists\ServerAddressList;
use app\services\review\hostsCollections\ReviewServiceClients;
use app\services\review\hostsCollections\ReviewServiceResponders;
use app\services\review\interfaces\ReviewServiceClient;
use app\services\review\interfaces\ReviewServiceDispatch;
use app\services\review\messages\client\ReviewServiceQueries;
use app\services\review\messages\client\ReviewServiceQuery;
use app\services\review\messages\server\ReviewServerResponse;
use app\services\review\messages\server\ServerResponses;
use Exception;

class ReviewServiceDispatcher implements ReviewServiceDispatcher, Identifiable {

    private int $id;
    private ReviewServiceQueries $queries;
    private ServerResponses $responses;
    private ReviewsServiceRespondPool $serverPool;
    private ReviewServiceClients $clients;

    private ServerAddressList $serverAddresses;
    private ClientAddressList $clientAddresses;

    /**
     * @param int $id
     */
    public function __construct (int $id) {
        $this->id = $id;
        $this->queries = new ReviewServiceQueries();;
        $this->responses = new ServerResponses();
        $this->serverAddresses = new ServerAddressList();
        $this->clientAddresses = new ClientAddressList();
        $this->servers = new ReviewServiceResponders();
        $this->clients = new ReviewServiceClients ();
    }

    public function getId (): int {
        return $this->id;
    }

    public function sendReviewServiceReviewServiceQuery (Re)

    /**
     * @throws Exception
     */
    public function receiveServerResponse (ReviewServerResponse $response): void {
        $client = $this->clients->pop($this->clients->searchByAddress($response->getClientAddress()));
        if (!is_null($client)) {
            $client->getResponse($response);
            $this->queries->drop($response->getQuery());
        }

    }

    /**
     * @throws Exception
     */
    public function receiveServiceQuery (ReviewServiceQuery $query): void {
        $client = $this->clients->searchByAddress($query->getClientAddress());
        $response = $this->findResponse($query);
        if (!is_null($response) && !is_null($client)) {
            $client->getResponse($response);
            $this->clients->remove($client);
        }
        $this->queries->enqueue($query);
    }

    public function findResponse (ReviewServiceQuery $query): ?ReviewServerResponse {
        $response = $this->responses->searchByQuery($query);
        if (is_null($response) && $this->serverPool->isEmpty())
            return null;
        else if (!$this->serverPool->isEmpty()) {
            $server = $this->serverPool->dequeue();
            $response = $server->getQuery($query);
            $this->serverPool->enqueue($server);
            return $response;
        }
        else return null;
    }
}