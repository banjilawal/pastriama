<?php declare(strict_types=1);

namespace app\services\reviewService\messages\collections;

use app\services\reviewService\messages\ReviewServiceQuery;
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
            throw new Exception ('ReviewServiceQuery ' . $query->getQueryId() . ' is already in the queue');
        }
        $this->queue->enqueue($query);
    }

    /**
     * @throws Exception
     */
    public function copy (): ReviewServiceQueries {
        $copy = new ReviewServiceQueries();
        $temp = new ReviewServiceQueries();
        $query = null;

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
    public function contains (ReviewServiceQuery $target): bool {
        $request = null;
        $temp = $this->copy();
        while (!$temp->isEmpty() || !$request->equals($target)) {
            $request = $temp->dequeue();
            if ($request->equals($target)) {
                return true;
            }
        }
        return false;
    }
}