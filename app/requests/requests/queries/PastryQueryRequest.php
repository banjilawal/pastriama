<?php

namespace app\requests\requests\queries;

use app\services\requests\Query;

class PastryQueryRequest extends Query {

    public function __construct () {}

    public function byName (string $pastryName)

}