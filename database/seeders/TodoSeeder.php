<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建测试用户
        $user1 = User::create([
            'name' => '测试用户1',
            'email' => 'test1@example.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => '测试用户2',
            'email' => 'test2@example.com',
            'password' => Hash::make('password'),
        ]);

        // 为用户1创建待办事项
        Todo::create([
            'user_id' => $user1->id,
            'title' => '完成项目文档',
            'description' => '编写项目的详细文档，包括API文档和用户手册',
            'category' => '工作',
            'completed' => false,
        ]);

        Todo::create([
            'user_id' => $user1->id,
            'title' => '学习Laravel框架',
            'description' => '深入学习Laravel的高级特性',
            'category' => '学习',
            'completed' => true,
        ]);

        Todo::create([
            'user_id' => $user1->id,
            'title' => '购买生活用品',
            'description' => '去超市购买日用品和食物',
            'category' => '生活',
            'completed' => false,
        ]);

        Todo::create([
            'user_id' => $user1->id,
            'title' => '完成代码审查',
            'description' => '审查团队成员的代码提交',
            'category' => '工作',
            'completed' => false,
        ]);

        // 为用户2创建待办事项
        Todo::create([
            'user_id' => $user2->id,
            'title' => '准备会议材料',
            'description' => '准备下周会议的PPT和资料',
            'category' => '工作',
            'completed' => false,
        ]);

        Todo::create([
            'user_id' => $user2->id,
            'title' => '运动健身',
            'description' => '去健身房进行有氧运动',
            'category' => '健康',
            'completed' => true,
        ]);

        Todo::create([
            'user_id' => $user2->id,
            'title' => '阅读技术书籍',
            'description' => '阅读《深入理解计算机系统》',
            'category' => '学习',
            'completed' => false,
        ]);
    }
}
