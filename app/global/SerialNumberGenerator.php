<?php

namespace app\global;

class SerialNumberGenerator {
    private static $instance;

    private int $userId;
    private int $pageLinkId;
//    public int $pageLinkId = 1;
//    public int $userId = 1;

    private function __construct () {
        $this->userId = 1;
        $this->pageLinkId = 1;
    }

    public static function getInstance (): SerialNumberGenerator {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function nextPageLinkId (): int {
        return $this->pageLinkId++;
    }

    public function nextUserId (): int {
        return $this->userId++;
    }

}