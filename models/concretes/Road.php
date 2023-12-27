<?php
namespace models\concretes;

use exceptions\EmptyStringException;
use global\Validate;
use models\enums\RoadCategory;
use models\interfaces\Nameable;

class Road {
    private string $name;
    private RoadCategory $category;
    
    /**
     * @throws EmptyStringException
     */
    public function __construct (string $name, RoadCategory $roadCategory) {
        $this->name = Validate::non_empty_string($name, 'Road', self::getName(), 15);//'name', 15);
        $this->category = $roadCategory;
    }
    
    public function getName (): string {
        return $this->name;
    }
    
    public function getCategory (): RoadCategory {
        return $this->category;
    }
    
    public function setName (string $name): void {
        $this->name = $name;
    }
    
    public function setCategory (RoadCategory $category): void {
        $this->category = $category;
    }
    
    public function equals ($object): bool {
        if ($object instanceof Road) {
            return $this->name === $object->getName() && $this->category === $object->getCategory();
        }
        return false;
    }
    
    public function __toString (): string {
        return $this->name . ' ' . RoadCategory::toString($this->category);
    }
} // end class Road