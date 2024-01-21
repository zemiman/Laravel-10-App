<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectCollection;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request){
        $validated=$request->validated();
        $project=Auth::user()->projects()->create($validated);
        return new ProjectResource($project);
    }
    public function update(UpdateProjectRequest $request, Project $project){
        $validated=$request->validated();
        $project->update($validated);
        return new ProjectResource($project);
    }
    public function destroy(Request $request, Project $project){
        $project->delete();
        return response()->noContent();
    }
    public function index(Request $request){
        $project=QueryBuilder::for(Project::class)
        ->allowedIncludes('tasks')
        ->paginate();
        // return new ProjectCollection(Auth::user()->projects()->paginate());
        return new ProjectCollection($project);
    }
    public function show(Request $request, Project $project){
        return (new ProjectResource($project))
        ->load('tasks')
        ->load('members');
    }
}
