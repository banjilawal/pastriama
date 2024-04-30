<?php

namespace app\interfaces;

use app\elements\PageElement;

interface PageAssembler {
    public static function buildDeepMain (Dashboard $dashboard): string;
    public static function buildDeepBody (Dashboard $dashboard): string;
    public static function buildSimpleMain (PageElement $page): string;
    public static function buildSimpleBody (PageElement $page): string;

    public static function factory (PageElement $page): string;
    public static function assemble (PageElement $page): string;

}