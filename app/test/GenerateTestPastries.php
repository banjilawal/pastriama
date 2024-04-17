<?php

namespace app\test;

use app\models\lists\Pastries;
use Exception;

class GenerateTestPastries {
    private int $size;

    /**
     * @throws Exception
     */
    public function __construct (int $size=10) {
        if ($size < 0) {
            throw new Exception('The list size must be greater than zero');
        }
        $this->size = $size;
    }

    public function getSize (): int {
        return $this->size;
    }

    /**
     * @throws Exception
     */
    public function setSize (int $size): void {
        if ($size < 0) {
            throw new Exception('The list size must be greater than zero');
        }
    }

    /**
     * @throws Exception
     */
    public static function pastryList (int $size=10): Pastries {
//        $generator = new OldPrimitiveGenerator();
        $pastryList = new Pastries();
        for ($index = 0; $index < $size; $index++) {
//            echo 'Generated FOod Description:' . OldPrimitiveGenerator::foodDescription() . '<br>' . PHP_EOL;
            $pastryList->add(EntityGenerator::pastry());
        }
        return $pastryList;
    }

}