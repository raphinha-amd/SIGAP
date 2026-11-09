<?php

namespace App\Services;

final readonly class UserImportResult
{
    /**
     * @param  array<int, string>  $errors
     */
    public function __construct(
        public int $total,
        public int $imported,
        public array $errors,
    ) {}

    public function failed(): int
    {
        return count($this->errors);
    }
}
