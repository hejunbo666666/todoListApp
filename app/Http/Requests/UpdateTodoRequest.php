<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 已通过认证中间件验证
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:50',
            'completed' => 'sometimes|boolean',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,md|max:10240', // 最大10MB
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
    return [
        'title.required' => 'Task title is required',
        'title.max' => 'Task title cannot exceed 255 characters',
        'description.max' => 'Task description cannot exceed 1000 characters',
        'category.max' => 'Category name cannot exceed 50 characters',
        'completed.boolean' => 'Completion status must be a boolean value',
        'file.file' => 'Invalid uploaded file',
        'file.mimes' => 'File type must be: jpg, jpeg, png, gif, pdf, doc, docx, txt, md',
        'file.max' => 'File size cannot exceed 10MB',
    ];
    }
}
