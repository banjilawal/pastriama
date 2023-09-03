<?php
namespace model;

use global\Validate;

class Road extends AnonymousEntity {
    private string $name;
    private \RoadCategory $category;
    
    /**
     * @throws \EmptyStringException
     */
    public function __construct (string $name, \RoadCategory $roadCategory) {
        $this->name = Validate::non_empty_string($name, 'Road', self::get_name(), 15);//'name', 15);
        $this->category = $roadCategory;
    }
    
    public function get_name (): string {
        return $this->name;
    }
    
    public function get_category (): \RoadCategory {
        return $this->category;
    }
    
    public function set_name (string $name): void {
        $this->name = $name;
    }
    
    public function set_category (\RoadCategory $category): void {
        $this->category = $category;
    }
    
    public function __toString (): string {
        return $this->name . \RoadCategory::toString($this->category);
    }
} // end class Road