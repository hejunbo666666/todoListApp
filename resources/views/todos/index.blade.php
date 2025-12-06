<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Todo List</title>
    <style>
        /* 重置和基础样式 */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --bg-color: #f9fafb;
            --card-bg: #ffffff;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 0.5rem;
            --radius-lg: 0.75rem;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            gap: 0.5rem;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background-color: var(--primary-hover);
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover:not(:disabled) {
            background-color: #dc2626;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .btn-outline:hover:not(:disabled) {
            background-color: var(--bg-color);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .form-input {
            width: 100%;
            padding: 0.625rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background-color: var(--card-bg);
            color: var(--text-primary);
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-file {
            padding: 0.5rem;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .navbar {
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand img {
            height: 2rem;
            width: auto;
        }

        .navbar-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .todo-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .todo-item {
            background-color: var(--card-bg);
            border-radius: var(--radius);
            padding: 1.25rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .todo-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .todo-item.completed {
            opacity: 0.7;
        }

        .todo-item.completed .todo-title {
            text-decoration: line-through;
            color: var(--text-secondary);
        }

        .todo-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
            margin-top: 0.25rem;
        }

        .todo-content {
            flex: 1;
            min-width: 0;
        }

        .todo-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .todo-title {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .todo-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: var(--bg-color);
            color: var(--text-secondary);
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .todo-description {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .todo-file {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background-color: var(--bg-color);
            border-radius: var(--radius);
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-decoration: none;
            margin-top: 0.5rem;
        }

        .todo-file:hover {
            background-color: var(--border-color);
        }

        .todo-actions {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.875rem;
            text-decoration: none;
            color: var(--text-primary);
        }

        .filter-btn:hover {
            background-color: var(--bg-color);
        }

        .filter-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .stats {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: var(--card-bg);
            border-radius: var(--radius-lg);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
            padding: 0.25rem;
        }

        .modal-close:hover {
            color: var(--text-primary);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state-icon {
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state-icon img {
            width: 4rem;
            height: auto;
        }

        .alert {
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .form-error {
            margin-top: 0.25rem;
            font-size: 0.75rem;
            color: var(--danger-color);
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.75rem;
            }

            .navbar-content {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-buttons {
                width: 100%;
            }

            .filter-btn {
                flex: 1;
            }

            .stats {
                width: 100%;
                justify-content: space-around;
            }

            .todo-item {
                flex-direction: column;
            }

            .todo-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-content">
            <a href="/todos" class="navbar-brand">
                <img src="{{ asset('storage/icon/代办事项.png') }}" alt="Todo List">
                <span>Todo List</span>
            </a>
            <div class="navbar-actions">
                <span style="color: var(--text-secondary);">{{ $user->name }}</span>
                <form method="POST" action="/logout" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- 统计信息 -->
        <div class="card">
            <div class="stats">
                <div class="stat-item">
                    <span class="stat-label">Total</span>
                    <span class="stat-value">{{ $stats['total'] }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Pending</span>
                    <span class="stat-value">{{ $stats['pending'] }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Completed</span>
                    <span class="stat-value">{{ $stats['completed'] }}</span>
                </div>
            </div>
        </div>

        <!-- 筛选栏 -->
        <div class="filter-bar">
            <div class="filter-buttons">
                <a href="/todos?filter=all" class="filter-btn {{ $currentFilter === 'all' ? 'active' : '' }}">All</a>
                <a href="/todos?filter=pending" class="filter-btn {{ $currentFilter === 'pending' ? 'active' : '' }}">Pending</a>
                <a href="/todos?filter=completed" class="filter-btn {{ $currentFilter === 'completed' ? 'active' : '' }}">Completed</a>
            </div>
            <button class="btn btn-primary" onclick="document.getElementById('todoModal').classList.add('active')">+ Add Task</button>
        </div>

        <!-- 待办事项列表 -->
        <div class="todo-list">
            @forelse($todos as $todo)
                <div class="todo-item {{ $todo->completed ? 'completed' : '' }}">
                    <form method="POST" action="/todos/{{ $todo->id }}/toggle" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="checkbox" class="todo-checkbox" {{ $todo->completed ? 'checked' : '' }} 
                               onchange="this.form.submit()">
                    </form>
                    <div class="todo-content">
                        <div class="todo-header">
                            <span class="todo-title">{{ $todo->title }}</span>
                            @if($todo->category)
                                <span class="todo-category">{{ $todo->category }}</span>
                            @endif
                        </div>
                        @if($todo->description)
                            <div class="todo-description">{{ $todo->description }}</div>
                        @endif
                        @if($todo->file_url)
                            <a href="{{ $todo->file_url }}" target="_blank" class="todo-file">
                                📎 {{ $todo->file_name ?: 'Attachment' }}
                            </a>
                        @endif
                    </div>
                    <div class="todo-actions">
                        <button class="btn btn-outline btn-sm" onclick="openEditModal({{ $todo->id }}, {{ json_encode($todo->title) }}, {{ json_encode($todo->description ?? '') }}, {{ json_encode($todo->category ?? '') }}, {{ json_encode($todo->file_url ?? '') }}, {{ json_encode($todo->file_name ?? '') }})">Edit</button>
                        <form method="POST" action="/todos/{{ $todo->id }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <img src="{{ asset('storage/icon/代办事项.png') }}" alt="Empty State">
                    </div>
                    <p>No todos yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- 添加/编辑任务模态框 -->
    <div class="modal" id="todoModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add Task</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form id="todoForm" method="POST" action="/todos" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="todoId" name="id">
                <input type="hidden" id="formMethod" name="_method" value="POST">
                <div class="form-group">
                    <label class="form-label" for="todoTitle">Task Title *</label>
                    <input type="text" id="todoTitle" name="title" class="form-input" required>
                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="todoDescription">Task Description</label>
                    <textarea id="todoDescription" name="description" class="form-input form-textarea"></textarea>
                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="todoCategory">Category</label>
                    <input type="text" id="todoCategory" name="category" class="form-input" placeholder="e.g., Work, Study, Life">
                    @error('category')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="todoFile">Attachment (Optional)</label>
                    <input type="file" id="todoFile" name="file" class="form-input form-file" accept="image/*,.pdf,.doc,.docx,.txt,.md">
                    <div id="currentFile" style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--text-secondary);"></div>
                    @error('file')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
                <div style="display: flex; gap: 0.75rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('todoModal').classList.remove('active');
            document.getElementById('todoForm').reset();
            document.getElementById('todoId').value = '';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('modalTitle').textContent = 'Add Task';
            document.getElementById('currentFile').textContent = '';
            document.getElementById('todoForm').action = '/todos';
        }

        function openEditModal(id, title, description, category, fileUrl, fileName) {
            document.getElementById('modalTitle').textContent = 'Edit Task';
            document.getElementById('todoId').value = id;
            document.getElementById('todoTitle').value = title;
            document.getElementById('todoDescription').value = description;
            document.getElementById('todoCategory').value = category;
            document.getElementById('todoFile').value = '';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('todoForm').action = '/todos/' + id;
            
            if (fileUrl) {
                document.getElementById('currentFile').innerHTML = 
                    'Current attachment: <a href="' + fileUrl + '" target="_blank">' + (fileName || 'View attachment') + '</a>';
            } else {
                document.getElementById('currentFile').textContent = '';
            }
            
            document.getElementById('todoModal').classList.add('active');
        }

        // 点击模态框外部关闭
        document.getElementById('todoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
