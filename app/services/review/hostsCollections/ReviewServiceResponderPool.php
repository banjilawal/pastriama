<?php declare(strict_types=1);

namespace app\services\review\hostsCollections;

use app\services\identifiers\ServerAddress;
use app\services\review\interfaces\ReviewServer;
use Exception;
use SplQueue;

class ReviewServiceResponderPool {

    private SplQueue $queue;

    /**
     */
    public function __construct () {
        $this->queue = new SplQueue();
    }

    public function isEmpty (): bool {
        return $this->queue->isEmpty();
    }

    public function dequeue (): ReviewServer {
        return $this->queue->dequeue();
    }

    /**
     * @throws Exception
     */
    public function enqueue (ReviewServer $server): void {
        if ($this->contains($server)) {
            throw new Exception ('ReviewServer '
                . $server->getAddress() . ' is already in the queue');
        }
        $this->queue->enqueue($server);
    }

    /**
     * @throws Exception
     */
    public function copy (): ReviewServiceResponderPool {
        $copy = new ReviewServiceResponderPool();
        $temp = new ReviewServiceResponderPool();

        while (!$this->queue->isEmpty()) {
            $query = $this->queue->dequeue();
            $temp->enqueue($query);
            $copy->enqueue($query);
        }

        while (!$temp->isEmpty()) {
            $this->queue->enqueue($temp->dequeue());
        }
        return $copy;
    }

    /**
     * @throws Exception
     */
    public function drop (ReviewServer $target): void {
        $server = null;
        $temp = new ReviewServiceResponderPool();
        while (!$this->queue->isEmpty() || !$server->equals($target)) {
            $server = $this->queue->dequeue();
            $temp->enqueue($server);
            if ($server->equals($target)) {
                $trash = $temp->dequeue();
                while (!$temp->isEmpty()) {
                    $this->enqueue($temp->dequeue());
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    public function searchByAddress (ServerAddress $address): ?ReviewServer {
        $server = null;
        $temp = new ReviewServiceResponderPool();
        while (!$this->queue->isEmpty() || !$server->getAddress->equals($address)) {
            $server = $this->queue->dequeue();
            $temp->enqueue($server);
            if ($server->getAddress()->equals($address)) {
                while (!$temp->isEmpty()) {
                    $this->enqueue($temp->dequeue());
                }
                return $server;
            }
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function search (ReviewServer $target): ?ReviewServer {
        $server = $this->searchByAddress($target->getAddress());
        if (!is_null($server)) {
            if ($server->equals($target)) { return $server; }
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function contains (ReviewServer $target): bool {
        return is_null($this->search($target));
    }
}