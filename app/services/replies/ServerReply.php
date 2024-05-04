<?php

namespace app\services\replies;

use app\interfaces\adapters\Equality;
use app\services\identifiers\ClientAddress;
use app\services\identifiers\ServerAddress;
use app\services\identifiers\ServerReplyIdentifier;


abstract class ServerReply implements Equality {

    private ServerReplyIdentifier $replyId;
    private ServerAddress $serverAddress;
    private ClientAddress $clientAddress;

    /**
     * @param ServerReplyIdentifier $id
     * @param ServerAddress $serverAddress
     * @param ClientAddress $clientAddress
     */
    public function __construct (
        ServerReplyIdentifier $id,
        ServerAddress $serverAddress,
        ClientAddress $clientAddress
    ) {
        $this->replyId = $id;
        $this->serverAddress = $serverAddress;
        $this->clientAddress = $clientAddress;

    }

    public function getReplyId (): ServerReplyIdentifier {
        return $this->replyId;
    }

    public function getServerAddress (): ServerAddress {
        return $this->serverAddress;
    }

    public function getClientAddress (): ClientAddress {
        return $this->clientAddress;
    }

    public function equals (object $object): bool {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof ServerReply) {
            return $this->replyId->equals($object->getReplyId())
                && $this->serverAddress->equals($object->getServerAddress())
                && $this->clientAddress->equals($object->getClientAddress());
        }
        return false;
    }
}