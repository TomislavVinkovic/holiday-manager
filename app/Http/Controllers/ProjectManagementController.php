<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Projects\IProjectRepository;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;

class ProjectManagementController extends Controller
{

    protected $projectRepository;

    public function __construct(IProjectRepository $projectRepository) {
        $this->projectRepository = $projectRepository;
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
        $this->projectRepository->createProject($request);

        return redirect(route('projectManagement'), 201);
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
        $id = $this->projectRepository->patchProject($request); //iskoristiti repo

        return redirect(route('projectManagement.show', $id));
    }

    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required|integer'
        ]);
        $this->projectRepository->destroyProject($request->id); //iskoristiti repo
        return redirect(route('projectManagement'));
    }
}
