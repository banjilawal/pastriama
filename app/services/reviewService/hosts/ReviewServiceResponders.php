<?php declare(strict_types=1);

namespace app\services\reviewService\hosts;

use app\services\identifiers\ServerAddress;
use app\services\reviewService\interfaces\ReviewServer;
use Exception;

class ReviewServiceResponders {
    private array $list;

    public function __construct () {
        $this->list = array();
    }

    public function getList (): ReviewServer|array {
        return $this->list;
    }


    /**
     * @throws Exception
     */
    public function add (ReviewServer $server): void {
        if ($this->contains($server)) {
            throw new Exception($server->getAddress() . ' is already in the list');
        }
        $this->list[] = $server;
    }

    /**
     * @throws Exception
     */
    public function remove (ReviewServer $server): void {
        $index = $this->getIndex($server);
        if ($index === PHP_INT_MIN) {
            throw new Exception('message:' . $server->getAddress() . ' not found. Reply remove failed');
        }
        unset($this->list[$index]);

    }

    public function searchById (ServerAddress $address): ?ReviewServer {
        foreach ($this->list as $server) {
            if ($server->getAddress()->equals($address))
                return $server;
        }
        return null;
    }

    public function contains (ReviewServer $target): bool {
        foreach ($this->list as $server) {
            if ($server->equals($target))
                return true;
        }
        return false;
    }

    public function getIndex (ReviewServer $server): int {
        for ($i = 0; $i < count($this->list); $i++) {
            if ($this->list[$i]->equals($server))
                return $i;
        }
        return PHP_INT_MIN;
    }
}