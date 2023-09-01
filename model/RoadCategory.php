<?php declare(strict_types=1);
    require_once('bootstrap.php');

    enum RoadCategory: String {
        case Ave = 'Avenue';
        case St = 'Street';
        case Rt = 'Route';
        case PL = 'Plaza';
        case LN = 'Lane';
        case Rd = 'Road';
        case Hwy = 'Highway';
        case PBox = 'PO Box';
        case None = 'None';
    } // end enum RoadCategory
?>