<?php declare(strict_types=1);

namespace models\enums;
require_once('bootstrap.php');

enum Orientation: string {
    case N = 'North';
    case NE = 'North East';
    case E = 'East';
    case SE = 'South East';
    case S = 'South';
    case SW = 'South West';
    case W = 'West';
    case NW = 'NorthWest';
    case None = 'None';
} // end enum Orientation