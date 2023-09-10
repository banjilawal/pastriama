<?php declare(strict_types=1);
namespace model\abstract;

use global\Validate;
use models\enums\EntityStatus;

//    require_once('../bootstrap.php');

abstract class Entity extends AnonymousEntity {
    private EntityStatus $status;
    private int $id;

    /**
     * @throws \Exception
     */
    public function __construct (int $id) {
        $this->status = EntityStatus::ACTIVE;
        $this->id = Validate::id($id);
    }

    public function get_id (): int { return $this->id; }
    public function get_status (): EntityStatus { return  $this->status; }

    /**
     * @throws \Exception
     */
    public function set_id (int $id): void { $this->id = Validate::id($id); }
    public function set_status (EntityStatus $status): EntityStatus { $this->status = $status; }
    
    public function print_status (): string {
        if ($this->status == EntityStatus::ACTIVE) return '';
        else return $this->status::toString() . ' ';
    }
    
    public function equals ($object): boolean {
        if ($object instanceof Entity) {
            return $this->id === $object->get_id();
        }
        return false;
    }

    public function __toString (): string { return $this->print_status() . 'id:' . $this->id; }
} // end class Entity
?>