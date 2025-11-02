@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-dark">
                        <i class="fas fa-edit me-2 text-primary"></i>Edit Task
                    </h4>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to Tasks
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Task Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold text-dark">Task Title *</label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $task->title) }}" 
                               placeholder="Enter task title..."
                               required>
                        @error('title')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Priority & Reminder Time -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="priority" class="form-label fw-semibold text-dark">Priority</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>
                                        <i class="fas fa-arrow-down me-2 text-success"></i>Low Priority
                                    </option>
                                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>
                                        <i class="fas fa-minus me-2 text-warning"></i>Medium Priority
                                    </option>
                                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>
                                        <i class="fas fa-arrow-up me-2 text-danger"></i>High Priority
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="reminder_time" class="form-label fw-semibold text-dark">Reminder Time *</label>
                                <input type="datetime-local" 
                                       class="form-control" 
                                       id="reminder_time" 
                                       name="reminder_time" 
                                       value="{{ old('reminder_time', $task->reminder_time->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('reminder_time')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold text-dark">Description</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Add task details, notes, or instructions...">{{ old('description', $task->description) }}</textarea>
                        <div class="form-text">Optional: Add more details about this task</div>
                        @error('description')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Task Info -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-dark mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Current Task Info
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Created</small>
                                    <p class="mb-2">{{ $task->created_at->format('M j, Y \\a\\t g:i A') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Status</small>
                                    <p class="mb-0">
                                        @if($task->is_completed)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Completed
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-outline-primary">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Update Task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-control, .form-select {
    border: 1px solid #d1d5db;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-control-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1rem;
}

.card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
}
</style>
@endsection