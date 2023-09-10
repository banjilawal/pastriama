<?php

namespace models\concretes;

use model\abstract\AnonymousEntity;
use models\enums\Orientation;

class StreetNumber extends AnonymousEntity {
    private AddressUnit $unit;
    private Road $road;
    private Orientation $orientation;
    
    /**
     * @param AddressUnit $unit
     * @param Road $road
     * @param Orientation $orientation
     */
    public function __construct (AddressUnit $unit, Road $road, Orientation $orientation) {
        $this->unit = $unit;
        $this->road = $road;
        $this->orientation = $orientation;
    }
    
    public function get_unit (): AddressUnit {
        return $this->unit;
    }
    
    public function get_road (): Road {
        return $this->road;
    }
    
    public function get_orientation (): Orientation {
        return $this->orientation;
    }
    
    public function set_unit (AddressUnit $unit): void {
        $this->unit = $unit;
    }
    
    public function set_road (Road $road): void {
        $this->road = $road;
    }
    
    public function set_orientation (Orientation $orientation): void {
        $this->orientation = $orientation;
    }
    
    public function __toString (): string {
        return $this->unit
            . ' ' . $this->road
            . ' ' . Orientation::toString($this->orientation);
    }
}