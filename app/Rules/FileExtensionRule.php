<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Throwable;

class FileExtensionRule implements Rule
{
    protected array $acceptedTypes;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $acceptedTypes)
    {
        $this->acceptedTypes = $acceptedTypes;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            // $mimeType = $value->getMimeType();
            // preg_match('/^(.*)\//', $mimeType, $res);
            // $type = $res[1];

            // return in_array($type, $this->acceptedTypes);
            $extension = $value->getClientOriginalExtension();
            return in_array($extension, $this->acceptedTypes);
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $types = implode(', ', $this->acceptedTypes);
        return 'File type invalid, accepted types: ' . $types;
    }
}
