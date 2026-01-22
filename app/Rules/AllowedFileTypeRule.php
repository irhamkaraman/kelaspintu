<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowedFileTypeRule implements ValidationRule
{
    protected $allowedTypes;

    public function __construct(?array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes ?? [];
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }

        // If no specific types are required, allow all files
        if (empty($this->allowedTypes)) {
            return;
        }

        $extension = strtolower($value->getClientOriginalExtension());
        
        if (!in_array($extension, $this->allowedTypes)) {
            $fail("Tipe file tidak diizinkan. Hanya boleh: " . implode(', ', $this->allowedTypes));
        }
    }
}
