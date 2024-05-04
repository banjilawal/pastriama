<?php declare(strict_types=1);

namespace app\interfaces\responsibilities;

interface BooleanValidator extends Valid {
    public function isTrue ($value): bool;
}