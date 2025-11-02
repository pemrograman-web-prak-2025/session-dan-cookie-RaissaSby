<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalTasks = Task::where('user_id', $user->id)->count();
        $completedTasks = Task::where('user_id', $user->id)->where('is_completed', true)->count();
        $pendingTasks = $totalTasks - $completedTasks;
        
        $upcomingTasks = Task::where('user_id', $user->id)
                            ->where('is_completed', false)
                            ->where('reminder_time', '>', now())
                            ->orderBy('reminder_time', 'asc')
                            ->take(5)
                            ->get();

        return view('dashboard', compact('totalTasks', 'completedTasks', 'pendingTasks', 'upcomingTasks'));
    }
}