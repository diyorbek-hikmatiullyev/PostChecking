<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
   public function rules(): array
{
    $role = auth()->user()->role;

    if ($role === 'jurnalist') {
        return [
            'status' => ['required', 'string', 'in:pending,accept,reject'],
        ];
    }

    if ($role === 'user') {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }

    if ($role === 'admin') {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'string', 'in:pending,accept,reject'],
        ];
    }

    abort(403, 'Sizda ruxsat yo‘q.');
}
}
