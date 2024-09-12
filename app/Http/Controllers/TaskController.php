<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class TaskController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

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
    public function storeTask(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'nullable|date|date_format:Y-m-d|after:yesterday',
            'attachment' => 'nullable|file|max:10240',
            'priority' => 'nullable',
            'tags' => 'nullable'
        ]);

        $count = Task::count();
        $task = new Task();
        $task->user_id = $request->user()->id;
        $task->title = $fields['title'];
        $task->description = $fields['description'];
        $task->completed = false;
        $task->archived = false;
        $task->order = $count > 0 ? $count + 1 : 1;

        if($request->due_date){
            $task->due_date = $fields['due_date'];
        }
        
        if($request->hasFile('attachment')) {
            $fields['attachment'] = $request->file('attachment')->store('attachments');
            $fields['attachment_name'] = $request->file('attachment')->getClientOriginalName();
            $task->attachment = $fields['attachment'];
            $task->attachment_name = $fields['attachment_name'];
        }

        if($request->priority){
            $task->priority_id = $fields['priority'];
        }

        if($request->tags) {
            $task->tags = $fields['tags'];
        }

        $task->save();

        return $task;

    }

    /**
     * Display the specified resource.
     */
    public function getUserTask($user_id)
    {
        $tasks = DB::select('
            SELECT
                t.*,
                p.name
            FROM tasks t
            LEFT JOIN priorities p ON p.id = t.priority_id
            WHERE t.user_id = ?
            AND t.archived = 0;
        ', [$user_id]);

        return $tasks;
    }

    public function getTask(Task $task) {

        $fileUrl = $task->attachment ? Storage::url($task->attachment) : null;

        return ['tasks' => $task, 'fileURL' => $fileUrl, 'fileName' => $task->attachment_name];
        // $tasks = DB::select('
        //     SELECT
        //         t.*,
        //         p.name
        //     FROM tasks t
        //     LEFT JOIN priorities p ON p.id = t.priority_id
        //     WHERE t.id = ?;
        // ', [$task_id]);

        // return ['tasks' => $tasks ];
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateTask(Task $task, Request $request)
    {
        Gate::authorize('modify', $task);
        $fields = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'due_date' => 'nullable|date|date_format:Y-m-d|after:yesterday',
            'attachment' => 'nullable|file|max:10240',
            'priority' => 'nullable',
            'tags' => 'nullable',
            'completed' => 'boolean',
        ]);

        $fields = $request;

        $task->title = $fields['title'];
        $task->description = $fields['description'];
        $task->completed = false;

        if($request->due_date){
            $task->due_date = $fields['due_date'];
        }
        
        if($request->hasFile('attachment')) {
            $fields['attachment'] = $request->file('attachment')->store('attachments');
            $fields['attachment_name'] = $request->file('attachment')->getClientOriginalName();
            $task->attachment = $fields['attachment'];
            $task->attachment_name = $fields['attachment_name'];
        }

        if($request->priority){
            $task->priority_id = $fields['priority'];
        }

        if($request->tags) {
            $task->tags = $fields['tags'];
        }

        $task->update();

        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task)
    {   
        Gate::authorize('modify', $task);

        $task->archived = 1;
        $task->update();
        return response()->json([
            'message' => 'Successfully deleted task'
        ]);
    }

    public function downloadAttachment(Task $task) {
        // return $task->attachment;
        return Storage::download($task->attachment, $task->attachment_name);
    }

    public function filterData(Request $request) {
        //filter code here
    }
}
