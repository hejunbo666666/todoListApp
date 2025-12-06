<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 显示待办事项列表
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Todo::where('user_id', $user->id);

        // 筛选功能
        $filter = $request->get('filter', 'all');
        if ($filter === 'completed') {
            $query->where('completed', true);
        } elseif ($filter === 'pending') {
            $query->where('completed', false);
        }

        // 排序
        $todos = $query->orderBy('created_at', 'desc')->get();

        // 添加文件URL
        $todos->each(function ($todo) {
            if ($todo->file_path) {
                $todo->file_url = asset('storage/' . $todo->file_path);
            }
        });

        // 统计信息
        $stats = [
            'total' => Todo::where('user_id', $user->id)->count(),
            'completed' => Todo::where('user_id', $user->id)->where('completed', true)->count(),
            'pending' => Todo::where('user_id', $user->id)->where('completed', false)->count(),
        ];

        return view('todos.index', [
            'todos' => $todos,
            'stats' => $stats,
            'currentFilter' => $filter,
            'user' => $user,
        ]);
    }

    /**
     * 创建待办事项
     */
    public function store(StoreTodoRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        // 处理文件上传
        $filePath = null;
        $fileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('todos', 'public');
        }

        Todo::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? 'Unclassified',
            'completed' => false,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        return redirect()->route('todos.index')->with('success', 'The to-do list has been successfully created!');
    }

    /**
     * 更新待办事项
     */
    public function update(UpdateTodoRequest $request, $id)
    {
        $user = Auth::user();
        $todo = Todo::where('user_id', $user->id)->findOrFail($id);
        $data = $request->validated();

        // 处理文件上传（如果提供了新文件）
        if ($request->hasFile('file')) {
            // 删除旧文件
            if ($todo->file_path) {
                Storage::disk('public')->delete($todo->file_path);
            }

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('todos', 'public');
            
            $data['file_path'] = $filePath;
            $data['file_name'] = $fileName;
        }

        $todo->update($data);

        return redirect()->route('todos.index')->with('success', 'The to-do list has been updated successfully!');
    }

    /**
     * 删除待办事项
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $todo = Todo::where('user_id', $user->id)->findOrFail($id);

        // 删除关联的文件
        if ($todo->file_path) {
            Storage::disk('public')->delete($todo->file_path);
        }

        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'The to-do list has been successfully deleted!');
    }

    /**
     * 切换完成状态
     */
    public function toggleComplete($id)
    {
        $user = Auth::user();
        $todo = Todo::where('user_id', $user->id)->findOrFail($id);
        
        $todo->completed = !$todo->completed;
        $todo->save();

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
}
