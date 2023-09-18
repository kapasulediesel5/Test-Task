<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxFileSize implements Rule
{
    protected $maxFileSize;  // Maximum file size in megabytes

    public function __construct($maxFileSize = 20)
    {
        $this->maxFileSize = $maxFileSize * 1024 * 1024;  // Convert MB to bytes
    }

    public function passes($attribute, $value)
    {
        // Check if the file size is within the limit
        return $value->getSize() <= $this->maxFileSize;
    }

    public function message(): string
    {
        return "The file size must not exceed 20 MB.";
    }
}

