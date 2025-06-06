<?php

namespace App\Http\Requests;

use App\Models\TaskStatus;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('tasks', 'name')->ignore($this->route('task'))
            ],
            'description' => ['nullable', 'string'],
            'status_id' => ['required', 'integer', 'exists:task_statuses,id'],
            'assigned_to_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('flash.This field is required'),
            'status_id.required' => __('flash.This field is required'),
        ];
    }
}
