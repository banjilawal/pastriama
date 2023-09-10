<?php
namespace models\concretes;

use exceptions\EmptyStringException;
use global\Validate;
use model\abstract\AnonymousEntity;
use models\interfaces\Nameable;

class Road extends AnonymousEntity implements Nameable {
    private string $name;
    private \models\enums\RoadCategory $category;
    
    /**
     * @throws EmptyStringException
     */
    public function __construct (string $name, \models\enums\RoadCategory $roadCategory) {
        $this->name = Validate::non_empty_string($name, 'Road', self::get_name(), 15);//'name', 15);
        $this->category = $roadCategory;
    }
    
    public function get_name (): string {
        return $this->name;
    }
    
    public function get_category (): \models\enums\RoadCategory {
        return $this->category;
    }
    
    public function set_name (string $name): void {
        $this->name = $name;
    }
    
    public function set_category (\models\enums\RoadCategory $category): void {
        $this->category = $category;
    }
    
    public function equals ($object): boolean {
        if ($object instanceof Road) {
            return $this->name === $object->get_name() && $this->category === $object->get_category();
        }
        return false;
    }
    
    public function __toString (): string {
        return $this->name . \models\enums\RoadCategory::toString($this->category);
    }
} // end class Road