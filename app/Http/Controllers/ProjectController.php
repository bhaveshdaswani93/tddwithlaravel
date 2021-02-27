<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        // $projects = Project::all();
        // dd(auth()->user());
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        //validation
        $attributes = request()->validate(
            [
                'title' => 'required',
                'description' => 'required',
                // 'owner_id' => 'required'
            ]
        );

        auth()->user()->projects()->create($attributes);

        //persit
        // Project::create($attributes);
        //response
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        // if ($project->owner_id !== auth()->id()) {
        //     abort(403);
        // }
        if ($project->owner->isNot(auth()->user())) {
            abort(403);
        }


        // $project = Project::findOrFail(\request('project'));
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }
}
