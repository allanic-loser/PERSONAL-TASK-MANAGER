<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Task</title>

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
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 20px 30px;
            font-size: 20px;
            font-weight: bold;
        }

        .container {
            max-width: 750px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 5px;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 25px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 15px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .save-button {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            padding: 11px 18px;
            cursor: pointer;
            font-weight: bold;
        }

        .cancel-button {
            background: #e5e7eb;
            color: #374151;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 7px;
            font-weight: bold;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        @media (max-width: 650px) {
            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="topbar">
    Personal Task Manager
</div>

<div class="container">

    <h1>Edit Task</h1>
    <p class="subtitle">Update the information for this task.</p>

    @if ($errors->any())
        <div class="error-box">
            <strong>Please check the following:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="task_name">Task Name</label>

                <input
                    id="task_name"
                    type="text"
                    name="task_name"
                    value="{{ old('task_name', $task->task_name) }}"
                    required>
            </div>

            <div class="field">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="row">

                <div class="field">
                    <label for="status">Status</label>

                    <select id="status" name="status" required>
                        <option value="Pending"
                            {{ old('status', $task->status) === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="Completed"
                            {{ old('status', $task->status) === 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label for="due_date">Due Date</label>

                    <input
                        id="due_date"
                        type="date"
                        name="due_date"
                        value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}"
                        required>
                </div>

            </div>

            <div class="buttons">
                <button type="submit" class="save-button">
                    Save Changes
                </button>

                <a href="{{ route('tasks.index') }}" class="cancel-button">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

</body>
</html>
