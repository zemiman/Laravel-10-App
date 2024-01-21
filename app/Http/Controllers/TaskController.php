<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    //
    public function index(){
        // return response()->json(Task::all());
        // return new TaskCollection(Task::paginate());
    $tasks = QueryBuilder::for(Task::class)
    ->allowedFilters('is_done')
    ->defaultSort('-created_at')
    ->allowedSorts(['title', 'is_done', 'created_at'])
    ->paginate();
    return new TaskCollection($tasks);
    }
    public function show(Request $request, Task $task) {
        return TaskResource::make($task);
        // return new TaskResource($task);
    }

    // public function store(Request $request){
    //     $validated=$request->validate([
    //         'title'=>'required|max:255'
    //     ]);
    //     $task=Task::create($validated);
    //     return new TaskResource($task);
    // }
    public function store(StoreTaskRequest $request){
        $validated=$request->validated();
        $task=Auth::user()->tasks()->create($validated);
        return new TaskResource($task);
    }
public function update(UpdateTaskRequest $request, Task $task){
    $validated=$request->validated();
    $task->update($validated);
    return new TaskResource($task);
}
public function destroy(Request $request, Task $task){
    $task->delete();
    return response()->noContent();
}
}
