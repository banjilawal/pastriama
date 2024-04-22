<?php

namespace app\enums;

enum HostType: int {
    case SERVER = 0;
    case CLIENT = 1;
    case DISPATCHER = 3;
}