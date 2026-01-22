<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ZipArchive;

class ZipContentRule implements ValidationRule
{
    protected $requiredFiles;

    public function __construct(array $requiredFiles = [])
    {
        $this->requiredFiles = $requiredFiles;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value || empty($this->requiredFiles)) {
            return;
        }

        $extension = strtolower($value->getClientOriginalExtension());
        
        if ($extension !== 'zip') {
            return;
        }

        $zip = new ZipArchive();
        $tempPath = $value->getRealPath();
        
        if ($zip->open($tempPath) !== true) {
            $fail("File ZIP tidak dapat dibuka.");
            return;
        }

        $filesInZip = [];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filesInZip[] = $zip->getNameIndex($i);
        }
        
        $missingFiles = [];
        foreach ($this->requiredFiles as $required) {
            $found = false;
            foreach ($filesInZip as $fileInZip) {
                if (basename($fileInZip) === $required || $fileInZip === $required) {
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $missingFiles[] = $required;
            }
        }
        
        $zip->close();
        
        if (!empty($missingFiles)) {
            $fail("File ZIP harus mengandung: " . implode(', ', $missingFiles));
        }
    }
}
