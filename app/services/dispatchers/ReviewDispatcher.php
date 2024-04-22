<?php

namespace app\services\dispatchers;

use app\interfaces\Identifiable;
use app\services\lists\ClientAddressList;
use app\services\lists\ServerAddressList;
use app\services\reviewService\hosts\ReviewServiceClients;
use app\services\reviewService\hosts\ReviewServiceResponders;
use app\services\reviewService\interfaces\ReviewServiceClient;
use app\services\reviewService\interfaces\ReviewServiceDispatcher;
use app\services\reviewService\messages\collections\ReviewServerResponses;
use app\services\reviewService\messages\collections\ReviewServiceQueries;
use app\services\reviewService\messages\ReviewServerResponse;
use app\services\reviewService\messages\ReviewServiceQuery;
use Exception;

class ReviewDispatcher implements ReviewServiceDispatcher, Identifiable {

    private int $id;
    private ReviewServiceQueries $serviceRequests;
    private ReviewServerResponses $serverReplies;
    private ReviewServiceResponders $servers;
    private ReviewServiceClients $clients;

    private ServerAddressList $serverAddresses;
    private ClientAddressList $clientAddresses;

    /**
     * @param int $id
     */
    public function __construct (int $id) {
        $this->id = $id;
        $this->serviceRequests = new ReviewServiceQueries();;
        $this->serverReplies = new ReviewServerResponses();
        $this->serverAddresses = new ServerAddressList();
        $this->clientAddresses = new ClientAddressList();
        $this->servers = new ReviewServiceResponders();
        $this->clients = new ReviewServiceClients ();
    }

    public function getId (): int {
        return $this->id;
    }


    /**
     * @throws Exception
     */
    public function receiveServerResponse (ReviewServerResponse $response): void {
        $index = $this->clients->searchByAddress($response->getClientAddress());
        if ($index != PHP_INT_MIN) {
            $this->forwardAnswer($this->clients[$index], $response->getAnswer());
        }

    }

    /**
     * @throws Exception
     */
    public function receiveServiceQuery (ReviewServiceQuery $query): void {
        $this->serviceRequests->enqueue($query);
    }

    public function forwardServiceQuery (): void {
        $request = $this->serviceRequests->dequeue();


    }

    public function forwardAnswer (ReviewServiceClient $client): void {
        $this->reviewServiceClient->receiveReviewServerReply($this->reviewServerReply);
    }
}