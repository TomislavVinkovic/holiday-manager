<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProjectManagementController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $projects = Project::all();
        return view('projectManagement.index', ['projects' => $projects]);
    }

    public function show($id) {
        $project = Project::where('id', $id)->with(['logo', 'teams'])->firstOrFail();
        return view('projectManagement.show', ['project' => $project]);
    }

    public function create() {
        $users = User::all();
        return view('projectManagement.create', ['users' => $users]);
    }

    public function store(ProjectCreateRequest $request) {
        $validated = $request->validated();

        $logo_id = Image::uploadAndCreateGetId($request->logo);
        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'lead_id' => $request->lead,
            'logo_id' => $logo_id
        ]);

        return redirect('projectmanagement', 201);
    }

    public function update($id) {
        $project = Project::findOrFail($id);
        $users = User::all();
        return view('projectManagement.update',
            [
                'project' => $project,
                'users' => $users
            ]
        );
    }

    public function patch(ProjectUpdateRequest $request) {
        $validated = $request->validated();
        $project = Project::findOrFail($request->id);
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'lead_id' => $request->lead
        ]);
        if($request->logo !== null) {
            Storage::delete($project->logo->file_path);
            $old_img = $project->logo_id;
            $project->logo_id = Image::uploadAndCreateGetId($request->logo);
            $project->save();
            Image::destroy($old_img);
        }

        return $this->show($project->id);
        die;
    }

    public function destroy(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);
            $project = Project::where('id', $request->id)->with('logo')->firstOrFail();
            Storage::delete($project->logo->file_path);
            $project->delete();
            return redirect('projectmanagement');
        }catch(Exception $e) {
            throw $e;
        }
    }
}
