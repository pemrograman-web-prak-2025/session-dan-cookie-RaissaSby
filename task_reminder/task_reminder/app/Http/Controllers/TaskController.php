<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'reminder_time' => 'required|date'
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'reminder_time' => $request->reminder_time,
            'priority' => $request->priority ?? 'medium'
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task berhasil dibuat!');
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'reminder_time' => 'required|date'
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'reminder_time' => $request->reminder_time,
            'priority' => $request->priority ?? 'medium'
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task berhasil diupdate!');
    }

    public function toggleComplete(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        $task->update(['is_completed' => !$task->is_completed]);
        return redirect()->back()->with('success', 'Status task diperbarui!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }
        
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task berhasil dihapus!');
    }
}