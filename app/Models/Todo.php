<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Todo extends Model
{
    use HasFactory;

    /**
     * 可批量赋值的属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'completed',
        'file_path',
        'file_name',
    ];

    /**
     * 类型转换
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * 验证规则
     *
     * @return array<string, string>
     */
    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:50',
            'completed' => 'boolean',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,md|max:10240', // 最大10MB
        ];
    }

    /**
     * 验证并保存模型
     *
     * @param array $attributes
     * @return bool
     * @throws ValidationException
     */
    public function validateAndSave(array $attributes): bool
    {
        $rules = self::rules();
        
        // 如果是更新，移除 file 规则（文件上传在控制器中处理）
        if ($this->exists) {
            unset($rules['file']);
        }
        
        $validator = validator($attributes, $rules);
        
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        
        $this->fill($attributes);
        return $this->save();
    }

    /**
     * 关联用户模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
