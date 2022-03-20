<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Http\Repositories\Projects\ProjectRepositoryInterface;
use App\Http\Repositories\Teams\TeamRepositoryInterface;
use App\Http\Repositories\Users\UserRepositoryInterface;
use App\Http\Requests\DeleteTeamProjectRequest;
use Illuminate\Support\Facades\Auth;


class TeamManagementController extends Controller
{   
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected UserRepositoryInterface $userRepository,
        protected ProjectRepositoryInterface $projectRepository
    ) {
        $this->middleware('auth');
    }

    public function index() {
        if(Auth::user()->is_superuser) {
            $teams = $this->teamRepository->getTeamsForSuperUser();
        }
        else $teams = $this->teamRepository->getTeamsForLead();
        return view('teamManagement.index', ['teams' => $teams]);
    }

    public function create($project_id = null) {
        $users = $this->userRepository->getUsersWithNoTeam();
        $max_id = $this->userRepository->getMaxId();
        if($project_id === null) {
            return view('teamManagement.create', ['users' => $users, 'max_id' => $max_id, 'project' => null]);
        }
        else {
            $project = $this->projectRepository->getProjectById($project_id);
            return view('teamManagement.create', ['users' => $users, 'max_id' => $max_id, 'project' => $project]);
        }
    }

    public function show($id) {
        $team = $this->teamRepository->getTeamById($id, ['logo', 'users', 'projects']);
        return view('teamManagement.show', ['team' => $team]);
    }

    public function store(TeamCreateRequest $request) {
        $validated = $request->validated();
        $this->teamRepository->createTeamWithMembers($request);
        return redirect(route('teamManagement'), 201);
    }

    public function update($id) {
        $data = $this->teamRepository->getUpdateInformation($id);
        return view('teamManagement.update', $data);
    }

    public function patch(TeamUpdateRequest $request) {
        $validated = $request->validated();
        $id = $this->teamRepository->patchTeam($request);
        return redirect(route('teamManagement.show', $id));
    }

    public function destroy(DeleteTeamProjectRequest $request) {
        $validated = $request->validated();
        $this->teamRepository->destroyTeamById($request->id);
        return redirect(route('teamManagement'));
    }

    public function removeMember(Request $request) {
        $request->validate([
            'team_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer']
        ]);
        
        $id = $this->teamRepository->removeMember($request->team_id, $request->user_id);
        return redirect(route('teamManagement.show', $id));
    }
}