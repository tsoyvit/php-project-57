<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskFilterRequest extends FormRequest
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
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'filter.status_id' => ['nullable', 'integer', 'exists:task_statuses,id'],
            'filter.created_by_id' => ['nullable', 'integer', 'exists:users,id'],
            'filter.assigned_to_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
