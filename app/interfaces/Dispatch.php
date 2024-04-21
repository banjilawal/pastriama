<?php

namespace app\interfaces;

interface Dispatch {

    public function forwardRequest (Server $server): Request;

    public function forwardReply (Client $client): Reply ;
}