<?php

namespace app\enums;

enum RequestStatus: string {
    case HANDLED = 'handled';
    case NOT_HANDLED = 'notHandled';
}