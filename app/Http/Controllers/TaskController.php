<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        return Task::select('tasks.*')
        ->whereIn('id', function ($query) {
            $query->selectRaw('MAX(id)')
                ->from('tasks')
                ->groupBy('empId');
        })
        ->orderBy('created_at', 'desc')
        ->get();    }

    public function show(Request $request)
    {
        $clientId = $request->query('employer');

        $task = Task::where('empId', $clientId)->latest()->first();
        return response()->json($task);    
    }

    public function store(Request $request) 
{
    $validatedData = $request->validate([
        'name' => 'required',
        'task' => 'required',
        'finished' => 'required',
        'duration' => 'required',
        'empId' => 'required',
        'seen' => 'required|boolean',
        'image' => 'nullable'
    ]);

    $imagePath = $request->file('image')->store('uploads', 'public');
    $validatedData['image'] = $imagePath;
    Task::create($validatedData);
    return response()->json(null, 204);  
}


    public function update(Task $task,Request $request)
    {
        
        $validatedData = $request->validate([
            'finished' => 'required'
        ]);
    
        $task->update($validatedData);
        return response()->json($task);

    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
