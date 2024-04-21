<?php declare(strict_types=1);


namespace app\servers\ReviewServer;


use app\interfaces\review\ReviewServer;
use app\services\review\ReviewClientRequest;

class ReviewServiceProvider implements ReviewServer {
    private ReviewClientRequest $request;

    /**
     * @param ReviewClientRequest $request
     */
    public function __construct (ReviewClientRequest $request) {
        $this->request = $request;
    }


    public function send (): ReviewServerReply {
        return new ReviewServerReply($this, $this->request->getClient(), 'I got your request');
    }

    public function receive (ReviewClientRequest $request): void {
        // TODO: Implement receive() method.
    }


}