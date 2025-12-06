<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 不使用外键约束
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->default('未分类');
            $table->boolean('completed')->default(false);
            $table->string('file_path')->nullable(); // 文件路径
            $table->string('file_name')->nullable(); // 原始文件名
            $table->timestamps();
            
            // 添加索引以提高查询性能（不使用外键）
            $table->index('user_id');
            $table->index('completed');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
};
