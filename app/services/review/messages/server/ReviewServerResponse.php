<?php declare(strict_types=1);

namespace app\services\review\messages\server;

use app\interfaces\adapters\Equality;
use app\services\identifiers\ServerReplyIdentifier;
use app\services\replies\ServerReply;
use app\services\review\messages\client\ReviewServiceQuery;

class ReviewServerResponse extends ServerReply implements Equality {

    private string $answer;
    private ReviewServiceQuery $query;

    /**
     * @param ServerReplyIdentifier $replyId
     * @param string $answer
     * @param ReviewServiceQuery $query
     */
    public function __construct (ServerReplyIdentifier $replyId, string $answer, ReviewServiceQuery $query) {
        parent::__construct($replyId);
        $this->answer = $answer;
        $this->query = $query;
    }

    public function getResponseId (): ServerReplyIdentifier {
        return $this->getReplyId();
    }

    public function getAnswer (): string {
        return $this->answer;
    }

    public function getQuery (): ReviewServiceQuery {
        return $this->query;
    }

    public function equals ($object): bool {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof ReviewServerResponse) {
            return parent::equals($object)
                && $this->answer === $object->getAnswer()
                && $this->query->equals($object->getQuery());

        }
        return false;
    }
}