<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::all();
        return view('admin.projects.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_data = $request->all();

        $project = new Project();

        $form_data['slug'] = Project::generateSlug($form_data['name'], '-');

        if ($request->hasFile('project_image')) {
            $path = Storage::disk('public')->put('project_image', $form_data['project_image']);
            $form_data['project_image'] = $path;
        }

        $project->fill($form_data);

        $project->save();

        return redirect()->route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $categories = Category::all();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $form_data = $request->validated();


        if ($request->hasFile('project_image')) {
    
            if (Str::startsWith($project->project_image, 'https') === false) {
                Storage::disk('public')->delete($project->project_image);
            }
    
    
            $path = Storage::disk('public')->put('project_image', $form_data['project_image']);
            $form_data['project_image'] = $path;
        }
    
        $form_data['slug'] = Project::generateSlug($form_data['name']);
    
        $project->update($form_data);
    
        return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Progetto eliminato con successo');
    }
}
