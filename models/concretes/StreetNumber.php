<?php

namespace models\concretes;

use models\enums\Orientation;

class StreetNumber {
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
    
    
    public function getUnit (): AddressUnit {
        return $this->unit;
    }
    
    
    public function getRoad (): Road {
        return $this->road;
    }
    
    
    public function getOrientation (): Orientation {
        return $this->orientation;
    }
    
    
    public function setUnit (AddressUnit $unit): void {
        $this->unit = $unit;
    }
    
    
    public function setRoad (Road $road): void {
        $this->road = $road;
    }
    
    
    public function setOrientation (Orientation $orientation): void {
        $this->orientation = $orientation;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof StreetNumber) {
            return $this->unit->equals($object->getUnit())
                && $this->road->equals($object->getRoad())
                && $this->orientation ===  $object->getOrientation();
        }
        return false;
    }
    
    
    public function __toString (): string {
        return $this->unit
            . ' ' . $this->road
            . ' ' . $this->orientation;
    }
}