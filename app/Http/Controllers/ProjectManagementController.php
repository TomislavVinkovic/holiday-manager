<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Projects\IProjectRepository;
use App\Http\Repositories\Teams\ITeamRepository;
use App\Http\Repositories\Users\IUserRepository;
use App\Http\Requests\ProjectAddExistingTeamsRequest;
use App\Models\User;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectRemoveTeamRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Team;
use App\Http\Requests\DeleteTeamProjectRequest;

class ProjectManagementController extends Controller
{

    public function __construct(
        protected IProjectRepository $projectRepository,
        protected ITeamRepository $teamRepository,
        protected IUserRepository $userRepository
    ) {
        $this->middleware('auth');
    }

    public function index() {
        $projects = $this->projectRepository->getProjects();
        return view('projectManagement.index', ['projects' => $projects]);
    }

    public function show($id) {
        $project = $this->projectRepository->getProjectById($id, ['teams', 'logo']);
        return view('projectManagement.show', ['project' => $project]);
    }

    public function create() {
        $users = $this->userRepository->getAllNonSuperUsers();
        return view('projectManagement.create', ['users' => $users]);
    }

    public function store(ProjectCreateRequest $request) {
        $validated = $request->validated();
        $this->projectRepository->createProject($request);

        return redirect(route('projectManagement'), 201);
    }

    public function update($id) {
        $project = $this->projectRepository->getProjectById($id);
        $users = $this->userRepository->getAllNonSuperUsers();
        return view('projectManagement.update',
            [
                'project' => $project,
                'users' => $users
            ]
        );
    }

    public function patch(ProjectUpdateRequest $request) {
        $validated = $request->validated();
        $id = $this->projectRepository->patchProject($request);

        return redirect(route('projectManagement.show', $id));
    }

    public function destroy(DeleteTeamProjectRequest $request) {
        $validated = $request->validated();
        $this->projectRepository->destroyProject($request->id);
        return redirect(route('projectManagement'));
    }

    public function addTeams($id) {
        $project = $this->projectRepository->getProjectById($id, ['teams']);
        $teams = $this->teamRepository->getTeamsNotInProject($project);
        return view('projectManagement.addTeams', ['project' => $project, 'teams' => $teams]);
        
    }

    public function storeTeams(ProjectAddExistingTeamsRequest $request) {
        $validated = $request->validated();
        $this->projectRepository->addTeamsToProject($request->project_id, $request->teams);
        return redirect(route('projectManagement.show', $request->project_id));
    }

    public function removeTeam(ProjectRemoveTeamRequest $request) {
        $valdiated = $request->validated();
        $this->projectRepository->removeTeamFromProject($request->project_id, $request->team_id);
        return redirect(route('projectManagement.show', $request->project_id));
    }
}
