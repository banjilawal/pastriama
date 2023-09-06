<?php

namespace models\concretes;

use exceptions\EmptyStringException;
use global\Validate;
use model\abstract\AnonymousEntity;
use models\enums\BuildingUnitCategory;
use models\interfaces\Nameable;

class AddressUnit extends AnonymousEntity {
    private string $unit;
    private BuildingUnitCategory $category;
    
    /**
     * @throws EmptyStringException
     */
    public function __construct (string $unit, BuildingUnitCategory $category) {
        $this->unit = Validate::non_empty_string($unit, 'BuildingUnit', 'unit', 15);
        $this->category = $category;
    }
    
    public function get_unit (): string { return $this->unit; }
    public function get_category (): BuildingUnitCategory { return $this->category; }
    
    /**
     * @throws EmptyStringException
     */
    public function set_unit (string $unit): void {
        $this->unit = Validate::non_empty_string($unit, 'BuildingUnit', 'unit', 22);
    }
    
    public function set_category (BuildingUnitCategory $category): void { $this->category = $category; }
    
    public function __toString (): string  { return $this->unit . ' ' . BuildingUnitCategory::toString($this->category); }
}