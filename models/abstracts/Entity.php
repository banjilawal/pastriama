<?php declare(strict_types=1);
namespace models\abstracts;

use Exception;

require_once('vendor\autoload.php');
//use global\Validate;


//    require_once('../bootstrap.php');

abstract class Entity {
//    private EntityStatus $status;
    private int $id;

    /**
     * @throws Exception
     */
    public function __construct (int $id) {
//        $this->status = EntityStatus::ACTIVE;
        $this->id = $id; //Validate::id($id);
    }

    public function getId (): int {
        return $this->id;
    }
    
    
//    public function getStatus (): EntityStatus {
//        return  $this->status;
//    }
    

    /**
     * @throws Exception
     */
//    public function setStatus (EntityStatus $status): void {
//        $this->status = $status;
//    }
    
    
//    public function printStatus (): string {
//        if ($this->status == EntityStatus::ACTIVE) return '';
//        else return $this->status::toString() . ' ';
//    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Entity) {
            return $this->id === $object->getId();
//                && $this->status == $object->getStatus();
        }
        return false;
    }

    
    public function __toString (): string {
        return ' id:' . $this->id;
    }
} // end class Entity