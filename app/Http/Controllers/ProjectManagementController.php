<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Projects\ProjectRepositoryInterface;
use App\Http\Repositories\Teams\TeamRepositoryInterface;
use App\Http\Repositories\Users\UserRepositoryInterface;
use App\Http\Requests\ProjectAddExistingTeamsRequest;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectRemoveTeamRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Requests\DeleteTeamProjectRequest;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\DisallowedDeletionException;
use Illuminate\Http\Response;

class ProjectManagementController extends Controller
{

    public function __construct(
        protected ProjectRepositoryInterface $projectRepository,
        protected TeamRepositoryInterface $teamRepository,
        protected UserRepositoryInterface $userRepository
    ) {
        $this->middleware('auth');
    }

    public function index() {
        if(Auth::user()->is_superuser) {
            $projects = $this->projectRepository->getProjectsForSuperUser();
        }
        else $projects = $this->projectRepository->getProjectsForLead();
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
        try {
            $this->projectRepository->removeTeamFromProject($request->project_id, $request->team_id);
            return response([
                'removed_team' => $request->team_id
            ], 200);
        } catch(DisallowedDeletionException $e) {
            return response([
                'error_message' => $e->getMessage()
            ], 500);
        }
    }
}
