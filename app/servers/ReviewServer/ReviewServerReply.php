<?php declare(strict_types=1);

namespace app\servers\ReviewServer;

use app\interfaces\review\ReviewClient;
use app\interfaces\review\ReviewServer;

class ReviewServerReply {

    private ReviewServer $source;
    private ReviewClient $destination;
    private string $data;

    /**
     * @param ReviewServer $source
     * @param ReviewClient $destination
     * @param string $data
     */
    public function __construct (ReviewServer $source, ReviewClient $destination, string $data) {
        $this->source = $source;
        $this->destination = $destination;
        $this->data = $data;
    }

    public function getSource (): ReviewServer {
        return $this->source;
    }

    public function getDestination (): ReviewClient {
        return $this->destination;
    }

    public function getData (): string {
        return $this->data;
    }

}