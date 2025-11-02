@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-dark">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Create New Task
                    </h4>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to Tasks
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    
                    <!-- Task Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold text-dark">
                            Task Title *
                            <span class="text-muted fw-normal">(What needs to be done?)</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="Enter your task title..."
                               required>
                        @error('title')
                            <div class="text-danger small mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Priority & Reminder Time -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="priority" class="form-label fw-semibold text-dark">Priority Level</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="low">
                                        <i class="fas fa-arrow-down me-2 text-success"></i>Low Priority
                                    </option>
                                    <option value="medium" selected>
                                        <i class="fas fa-minus me-2 text-warning"></i>Medium Priority
                                    </option>
                                    <option value="high">
                                        <i class="fas fa-arrow-up me-2 text-danger"></i>High Priority
                                    </option>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1 text-info"></i>
                                    Choose how urgent this task is
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="reminder_time" class="form-label fw-semibold text-dark">
                                    Reminder Time *
                                    <span class="text-muted fw-normal">(When to remind you?)</span>
                                </label>
                                <input type="datetime-local" 
                                       class="form-control" 
                                       id="reminder_time" 
                                       name="reminder_time" 
                                       value="{{ old('reminder_time') }}" 
                                       required>
                                @error('reminder_time')
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold text-dark">
                            Description
                            <span class="text-muted fw-normal">(Optional details)</span>
                        </label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Add any additional details, notes, or instructions for this task...">{{ old('description') }}</textarea>
                        <div class="form-text">
                            <i class="fas fa-lightbulb me-1 text-warning"></i>
                            Add context or specific instructions to help you remember
                        </div>
                        @error('description')
                            <div class="text-danger small mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Quick Tips -->
                    <div class="card border-primary bg-light mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-primary mb-3">
                                <i class="fas fa-tips me-2"></i>Quick Tips
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-bell text-warning mt-1 me-2"></i>
                                        <div>
                                            <small class="fw-semibold d-block">Set Clear Reminders</small>
                                            <small class="text-muted">Choose a specific date and time</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="fas fa-flag text-danger mt-1 me-2"></i>
                                        <div>
                                            <small class="fw-semibold d-block">Use Priority Wisely</small>
                                            <small class="text-muted">Mark urgent tasks as High priority</small>
                                        </div>
                                    </div>
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
                                <i class="fas fa-undo me-2"></i>Clear Form
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-plus me-2"></i>Create Task
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
    background: white;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: white;
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
    padding: 0.625rem 1.25rem;
}

.form-text {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>

<script>
// Set minimum datetime to current time
document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
        .toISOString()
        .slice(0, 16);
    
    const reminderField = document.getElementById('reminder_time');
    if (!reminderField.value) {
        reminderField.value = localDateTime;
    }
    reminderField.min = localDateTime;
});
</script>
@endsection