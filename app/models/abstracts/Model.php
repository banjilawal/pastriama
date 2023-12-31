<?php declare(strict_types=1);

namespace app\models\abstracts;

abstract class Model {

    function __construct () { }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        return false;
    }

    public function __toString (): string {
//        $classTree = explode('\\', __CLASS_);
//        $leaf = $classTree[len($classTree) - 1];
//        echo $leaf;
        return '';
    }
}