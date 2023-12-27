<?php

namespace models\concretes;

use global\Validate;
use exceptions\EmptyStringException;
use models\enums\BuildingUnitCategory;

class AddressUnit {
    private string $unit;
    private BuildingUnitCategory $category;
    
    /**
     * @throws EmptyStringException
     */
    public function __construct (string $unit, BuildingUnitCategory $category) {
        $this->unit = Validate::non_empty_string($unit, 'BuildingUnit', 'unit', 15);
        $this->category = $category;
    }
    
    public function getUnit (): string {
        return $this->unit;
    }
    
    
    public function getCategory (): BuildingUnitCategory {
        return $this->category;
    }


    /**
     * @throws EmptyStringException
     */
    public function setUnit (string $unit): void {
        $this->unit = Validate::non_empty_string($unit, 'BuildingUnit', 'unit', 22);
    }


    public function setCategory (BuildingUnitCategory $category): void {
        $this->category = $category;
    }


    public function __toString (): string  {
        return $this->unit . ' ' . BuildingUnitCategory::toString($this->category);
    }
    
    
    public function equals($object): bool {
        if ($object instanceof AddressUnit) {
            return $this->unit === $object->getUnit()
                && $this->category === $object->getCategory();
        }
        return false;
    }
}