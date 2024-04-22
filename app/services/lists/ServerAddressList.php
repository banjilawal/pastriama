<?php declare(strict_types=1);

namespace app\services\lists;

use app\services\identifiers\ServerAddress;

use Exception;

class ServerAddressList {
    private array $list;

    public function __construct () {
        $this->list = array();
    }

    public function getList (): ServerAddress|array {
        return $this->list;
    }


    /**
     * @throws Exception
     */
    public function add (ServerAddress $id): void {
        if ($this->contains($id)) {
            throw new Exception($id . ' is already in the list');
        }
        $this->list[] = $id;
    }

    /**
     * @throws Exception
     */
    public function remove (ServerAddress $id): void {
        $index = $this->getIndex($id);
        if ($index === PHP_INT_MIN) {
            throw new Exception('message:' . $id . ' not found. Reply remove failed');
        }
        unset($this->list[$index]);

    }

    public function contains (ServerAddress $target): bool {
        foreach ($this->list as $id) {
            if ($id->equals($target))
                return true;
        }
        return false;
    }

    public function getIndex (ServerAddress $id): int {
        for ($i = 0; $i < count($this->list); $i++) {
            if ($this->list[$i]->equals($id))
                return $i;
        }
        return PHP_INT_MIN;
    }
}