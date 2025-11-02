@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-muted">Here's what's happening with your tasks today.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Task
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-4 mb-3">
        <div class="stat-card primary">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-1">{{ $totalTasks }}</h3>
                    <p class="mb-0 opacity-90">Total Tasks</p>
                </div>
                <i class="fas fa-tasks fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card success">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-1">{{ $completedTasks }}</h3>
                    <p class="mb-0 opacity-90">Completed</p>
                </div>
                <i class="fas fa-check-circle fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card warning">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-1">{{ $pendingTasks }}</h3>
                    <p class="mb-0 opacity-90">Pending</p>
                </div>
                <i class="fas fa-clock fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('tasks.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-plus me-2"></i>Create New Task
                    </a>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-list me-2"></i>View All Tasks
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Progress</h5>
                @if($totalTasks > 0)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Completion Rate</span>
                        <span>{{ number_format(($completedTasks / $totalTasks) * 100, 1) }}%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ ($completedTasks / $totalTasks) * 100 }}%"></div>
                    </div>
                </div>
                @endif
                <div class="text-center">
                    <small class="text-muted">
                        {{ $completedTasks }} of {{ $totalTasks }} tasks completed
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Upcoming Reminders</h5>
                    <span class="badge bg-primary">{{ $upcomingTasks->count() }} tasks</span>
                </div>

                @if($upcomingTasks->count() > 0)
                    <div class="space-y-3">
                        @foreach($upcomingTasks as $task)
                        <div class="task-item priority-{{ $task->priority }} p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="task-title mb-1">{{ $task->title }}</h6>
                                    @if($task->description)
                                    <p class="text-muted small mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    <div class="d-flex align-items-center gap-3 text-sm text-muted">
                                        <span><i class="fas fa-clock me-1"></i>{{ $task->reminder_time->format('M j, Y • g:i A') }}</span>
                                        <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
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
                                                    <i class="fas fa-check me-2"></i>Mark Complete
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
                @else
                    <div class="empty-state">
                        <i class="fas fa-bell-slash"></i>
                        <h5>No upcoming reminders</h5>
                        <p class="text-muted">Tasks with reminder times will appear here</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-2"></i>Create Your First Task
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection