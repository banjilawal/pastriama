<?php declare(strict_types=1);

namespace app\models\abstracts;


abstract class Address extends Model {
    function __construct () {
        parent::__construct();
    }

    public function equals ($object):  bool {
        if ($this === $object) return true;
        else return false;
    }

    public function __toString (): string {
        return parent::__toString();
    }
}