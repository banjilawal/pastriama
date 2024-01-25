<?php

namespace app\query\select\clause\orderBy;

use app\query\select\clause\Clause;

class OrderByClause extends Clause {
    public const DIRECTIONS = ['asc', 'desc', 'ASC', 'DESC"'];

    private string $direction;

    /**
     * @param string $direction
     * @throws \Exception
     */
    public function __construct (string $column, string $direction) {
        if (!in_array($direction, self::DIRECTIONS)) {
            throw new \Exception('the direction value must be either \'asc\' or \'desc\'.');
        }
        parent::__construct($column);
        $this->direction = $direction;
    }

    public function getDirection (): string {
        return $this->direction;
    }

    /**
     * @throws \Exception
     */
    public function setDirection (string $direction): void {
        if (!in_array($direction, self::DIRECTIONS)) {
            throw new \Exception('the direction value must be either \'asc\' or \'desc\'');
        }
        $this->direction = $direction;
    }

    public function __toString ():string {
        return parent::__toString() .  ' ' . strtoupper($this->direction);
    }
}