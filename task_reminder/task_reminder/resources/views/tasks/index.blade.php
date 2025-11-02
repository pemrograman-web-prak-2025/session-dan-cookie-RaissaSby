@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">My Tasks</h1>
                <p class="text-muted">Manage your tasks and reminders</p>
            </div>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Task
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <form action="{{ route('tasks.index') }}" method="GET" class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary btn-sm">All</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">Active</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">Completed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($tasks->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="space-y-3">
                    @foreach($tasks as $task)
                    <div class="task-item priority-{{ $task->priority }} p-3 {{ $task->is_completed ? 'completed' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start gap-3">
                                    <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST" class="mt-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $task->is_completed ? 'btn-success' : 'btn-outline-secondary' }} rounded-circle p-0" style="width: 24px; height: 24px;">
                                            @if($task->is_completed)
                                            <i class="fas fa-check text-white" style="font-size: 0.7rem;"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <div class="flex-grow-1">
                                        <h6 class="task-title mb-1">{{ $task->title }}</h6>
                                        @if($task->description)
                                        <p class="text-muted small mb-2">{{ $task->description }}</p>
                                        @endif
                                        <div class="d-flex align-items-center gap-3 text-sm text-muted">
                                            <span><i class="fas fa-clock me-1"></i>{{ $task->reminder_time->format('M j, Y • g:i A') }}</span>
                                            <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            @if($task->is_completed)
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Completed</span>
                                            @else
                                            <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-{{ $task->is_completed ? 'undo' : 'check' }} me-2"></i>
                                                {{ $task->is_completed ? 'Mark Incomplete' : 'Mark Complete' }}
                                            </button>
                                        </form>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('tasks.edit', $task) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Delete this task?')">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="empty-state">
                    <i class="fas fa-tasks"></i>
                    <h5>No tasks yet</h5>
                    <p class="text-muted">Get started by creating your first task</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Task
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection