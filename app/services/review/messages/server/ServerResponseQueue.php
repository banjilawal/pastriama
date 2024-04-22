<?php declare(strict_types=1);

namespace app\services\review\messages\server;

use Exception;
use SplQueue;

class ServerResponseQueue {

    private SplQueue $queue;

    /**
     */
    public function __construct () {
        $this->queue = new SplQueue();
    }

    public function isEmpty (): bool {
        return $this->queue->isEmpty();
    }

    public function dequeue (): ReviewServerResponse {
        return $this->queue->dequeue();
    }

    /**
     * @throws Exception
     */
    public function enqueue (ReviewServerResponse $request): void {
        if ($this->contains($request)) {
            throw new Exception ('ReviewServerResponse ' . $request->getReplyId() . ' is already in the queue');
        }
        $this->queue->enqueue($request);
    }

    /**
     * @throws Exception
     */
    public function copy (): ServerResponseQueue {
        $copy = new ServerResponseQueue();
        $temp = new ServerResponseQueue();
        $request = null;

        while (!$this->queue->isEmpty()) {
            $request = $this->queue->dequeue();
            $temp->enqueue($request);
            $copy->enqueue($request);
        }

        while (!$temp->isEmpty()) {
            $this->queue->enqueue($temp->dequeue());
        }
        return $copy;
    }

    /**
     * @throws Exception
     */
    public function contains (ReviewServerResponse $target): bool {
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