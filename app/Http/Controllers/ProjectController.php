<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        //validation
        //persit
        Project::create(request(['title', 'description']));
        //response
        return redirect('/projects');
    }
}
