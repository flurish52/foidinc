<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'sliders_new.*' => 'nullable|file|image',
            'sliders_existing' => 'nullable|array',
            'content' => 'required|string',
            'parent_id' => 'nullable|numeric|exists:pages,id',
            'main' => 'nullable|boolean',
            'position' => 'nullable|numeric',
        ];

    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'content.required' => 'Content cannot be empty',
            'status.in' => 'Status must be either draft or published',
        ];
    }

}
