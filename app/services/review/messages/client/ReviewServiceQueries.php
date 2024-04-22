<?php declare(strict_types=1);

namespace app\services\review\messages\client;

use Exception;
use SplQueue;

class ReviewServiceQueries {

    private SplQueue $queue;

    /**
     */
    public function __construct () {
        $this->queue = new SplQueue();
    }

    public function isEmpty (): bool {
        return $this->queue->isEmpty();
    }

    public function dequeue (): ReviewServiceQuery {
        return $this->queue->dequeue();
    }

    /**
     * @throws Exception
     */
    public function enqueue (ReviewServiceQuery $query): void {
        if ($this->contains($query)) {
            throw new Exception ('ReviewServiceQuery '
                . $query->getQueryId() . ' is already in the queue');
        }
        $this->queue->enqueue($query);
    }

    /**
     * @throws Exception
     */
    public function copy (): ReviewServiceQueries {
        $copy = new ReviewServiceQueries();
        $temp = new ReviewServiceQueries();

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
    public function drop (ReviewServiceQuery $target): void {
        $query = null;
        $temp = new ReviewServiceQueries();
        while (!$this->queue->isEmpty() || !$query->equals($target)) {
            $query = $this->queue->dequeue();
            $temp->enqueue($query);
            if ($query->equals($target)) {
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
    public function search (ReviewServiceQuery $target): ?ReviewServiceQuery {
        $query = null;
        $temp = new ReviewServiceQueries();
        while (!$this->queue->isEmpty() || !$query->equals($target)) {
            $query = $this->queue->dequeue();
            $temp->enqueue($query);
            if ($query->equals($target)) {
                while (!$temp->isEmpty()) {
                    $this->enqueue($temp->dequeue());
                }
                return $query;
            }
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function contains (ReviewServiceQuery $target): bool {
        return is_null($this->search($target));
    }
}