<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'date|date_format:Y-m-d|before:tomorrow',
            'attachment' => 'file|mimetypes:image/jpeg,image/png,application/pdf,application/msword,video/mp4|max:10240',
            'tags' => 'string'
        ]);

        $task = Task::create($fields);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return 'show';
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        return 'destroy';
    }
}
