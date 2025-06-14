<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('tasks', 'name')->ignore($this->route('task')),
            ],
            'description' => ['nullable', 'string'],
            'status_id' => ['required', 'integer', 'exists:task_statuses,id'],
            'assigned_to_id' => ['nullable', 'integer', 'exists:users,id'],
            'labels' => ['nullable', 'array'],
            'labels.*' => ['integer', 'exists:labels,id'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function messages(): array
    {
        return [
            'name.unique' => __('validation.task.unique'),
        ];
    }
}
