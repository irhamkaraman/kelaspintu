<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FileSizeRule implements ValidationRule
{
    protected $maxSizeMb;

    public function __construct($maxSizeMb = 10)
    {
        $this->maxSizeMb = $maxSizeMb;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }

        $fileSizeMb = $value->getSize() / 1024 / 1024;
        
        if ($fileSizeMb > $this->maxSizeMb) {
            $fail("File tidak boleh lebih dari {$this->maxSizeMb} MB. Ukuran file Anda: " . number_format($fileSizeMb, 2) . " MB");
        }
    }
}
