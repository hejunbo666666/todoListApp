<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:50',
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
        'title.required' => 'The task title is required',
        'title.max' => 'The task title may not exceed 255 characters',
        'description.max' => 'The task description may not exceed 1000 characters',
        'category.max' => 'The category name may not exceed 50 characters',
        'file.file' => 'The uploaded file is invalid',
        'file.mimes' => 'The file type must be: jpg, jpeg, png, gif, pdf, doc, docx, txt, md',
        'file.max' => 'The file size may not exceed 10MB',
    ];
}
}
