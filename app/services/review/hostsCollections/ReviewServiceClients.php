<?php declare(strict_types=1);

namespace app\services\review\hostsCollections;

use app\services\identifiers\ClientAddress;
use app\services\review\interfaces\ReviewServiceClient;
use Exception;

class ReviewServiceClients {
    private array $list;

    public function __construct () {
        $this->list = array();
    }

    public function getList (): ReviewServiceClient|array {
        return $this->list;
    }


    /**
     * @throws Exception
     */
    public function add (ReviewServiceClient $client): void {
        if ($this->contains($client)) {
            throw new Exception($client->getAddress() . ' is already in the list');
        }
        $this->list[] = $client;
    }

    /**
     * @throws Exception
     */
    public function pop (ReviewServiceClient $client): ?ReviewServiceCLient {
        $index = $this->getIndex($client);
        if ($index != PHP_INT_MIN) {
            $result = $this->list[$index];
            unset($this->list[$index]);
            return $result;
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function remove (ReviewServiceClient $client): void {
        $index = $this->getIndex($client);
        if ($index === PHP_INT_MIN) {
            throw new Exception('message:' . $client->getAddress() . ' not found. Reply remove failed');
        }
        unset($this->list[$index]);
    }

    public function searchByAddress (ClientAddress $address): ?ReviewServiceClient {
        foreach ($this->list as $client) {
            if ($client->getAddress()->equals($address))
                return $client;
        }
        return null;
    }

    public function contains (ReviewServiceClient $target): bool {
        foreach ($this->list as $client) {
            if ($client->equals($target))
                return true;
        }
        return false;
    }

    public function getIndex (ReviewServiceClient $client): int {
        if (is_null($client)) return PHP_INT_MIN;
        for ($i = 0; $i < count($this->list); $i++) {
            if ($this->list[$i]->equals($client))
                return $i;
        }
        return PHP_INT_MIN;
    }
}