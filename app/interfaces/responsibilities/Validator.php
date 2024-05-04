<?php declare(strict_types=1);

namespace app\interfaces\responsibilities;

interface Validator extends Valid {
    public function validate ($value): void;
}