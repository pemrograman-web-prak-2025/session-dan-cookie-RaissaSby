@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
        <hr>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalTasks }}</h4>
                        <p>Total Tasks</p>
                    </div>
                    <i class="fas fa-tasks fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $completedTasks }}</h4>
                        <p>Completed</p>
                    </div>
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $pendingTasks }}</h4>
                        <p>Pending</p>
                    </div>
                    <i class="fas fa-clock fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-bell"></i> Upcoming Reminders</h5>
            </div>
            <div class="card-body">
                @if($upcomingTasks->count() > 0)
                    @foreach($upcomingTasks as $task)
                    <div class="card mb-2 priority-{{ $task->priority }}">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $task->title }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> 
                                        {{ $task->reminder_time->format('d M Y H:i') }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">Tidak ada pengingat yang akan datang.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-rocket"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-plus"></i> Buat Task Baru
                </a>
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-list"></i> Lihat Semua Tasks
                </a>
            </div>
        </div>
    </div>
</div>
@endsection