<?php declare(strict_types=1);
namespace model\abstract;

use global\Validate;

//    require_once('../bootstrap.php');

abstract class Entity extends AnonymousEntity {
    private int $id;

    /**
     * @throws \Exception
     */
    public function __construct (int $id) { $this->id = Validate::id($id); }

    public function get_id (): int { return $this->id; }

    /**
     * @throws \Exception
     */
    public function set_id (int $id): void { $this->id = Validate::id($id); }

    public function __toString (): string { return 'id:' . $this->id; }
} // end class Entity
?>