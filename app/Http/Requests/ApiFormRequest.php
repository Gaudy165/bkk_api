<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiFormRequest extends FormRequest
{
    /**
     * Force all API form requests to return JSON (e.g., validation errors)
     * even when the client does not set Accept: application/json.
     */
    public function expectsJson(): bool
    {
        return true;
    }
}
