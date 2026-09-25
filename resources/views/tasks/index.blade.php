<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #1f2937;
        }

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 20px 30px;
        }

        .topbar h2 {
            margin: 0;
            color: #374151;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .heading h1 {
            margin: 0 0 5px;
        }

        .heading p {
            margin: 0;
            color: #6b7280;
        }

        .add-button {
            background: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 8px;
            font-weight: bold;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .task-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .task-top {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .task-card h3 {
            margin: 0 0 8px;
        }

        .description {
            color: #6b7280;
            margin: 5px 0 12px;
        }

        .due-date {
            font-size: 14px;
            color: #6b7280;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .completed {
            background: #d1fae5;
            color: #065f46;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .actions form {
            margin: 0;
        }

        button,
        .edit-button {
            border: none;
            border-radius: 6px;
            padding: 8px 12px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .status-button {
            background: #0f766e;
            color: white;
        }

        .edit-button {
            background: #2563eb;
            color: white;
        }

        .delete-button {
            background: #dc2626;
            color: white;
        }

        .empty {
            background: white;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>

<body>

<div class="topbar">
    <h2>Personal Task Manager</h2>
</div>

<div class="container">

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="heading">
        <div>
            <h1>Task Dashboard</h1>
            <p>Organize and monitor your personal tasks.</p>
        </div>

        <a href="{{ route('tasks.create') }}" class="add-button">
            Add New Task
        </a>
    </div>

    @forelse ($tasks as $task)

        <div class="task-card">

            <div class="task-top">
                <div>
                    <h3>{{ $task->task_name }}</h3>

                    <p class="description">
                        {{ $task->description ?: 'No description provided.' }}
                    </p>

                    <div class="due-date">
                        Due: {{ $task->due_date->format('M d, Y') }}
                    </div>
                </div>

                <div>
                    <span class="badge {{ $task->status === 'Completed' ? 'completed' : 'pending' }}">
                        {{ $task->status }}
                    </span>
                </div>
            </div>

            <div class="actions">

                <form action="{{ route('tasks.status', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <input
                        type="hidden"
                        name="status"
                        value="{{ $task->status === 'Completed' ? 'Pending' : 'Completed' }}">

                    <button type="submit" class="status-button">
                        {{ $task->status === 'Completed' ? 'Set Pending' : 'Complete Task' }}
                    </button>
                </form>

                <a href="{{ route('tasks.edit', $task) }}" class="edit-button">
                    Edit
                </a>

                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="delete-button">
                        Delete
                    </button>
                </form>

            </div>

        </div>

    @empty

        <div class="empty">
            No tasks available. Add your first task.
        </div>

    @endforelse

</div>

</body>
</html>
