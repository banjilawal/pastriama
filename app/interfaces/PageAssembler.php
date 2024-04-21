<?php

namespace app\interfaces;

use app\pages\Page;

interface PageAssembler {
    public static function buildDeepMain (Dashboard $dashboard): string;
    public static function buildDeepBody (Dashboard $dashboard): string;
    public static function buildSimpleMain (Page $page): string;
    public static function buildSimpleBody (Page $page): string;

    public static function factory (Page $page): string;
    public static function assemble (Page $page): string;

}