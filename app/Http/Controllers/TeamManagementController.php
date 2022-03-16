<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Http\Repositories\Teams\ITeamRepository;
use App\Models\User;


class TeamManagementController extends Controller
{
    
    protected $teamRepository;
    
    public function __construct(ITeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
        $this->middleware('auth');
    }

    public function index() {
        $teams = Team::all();
        return view('teamManagement.index', ['teams' => $teams]);
    }

    public function create() {
        $users = User::doesntHave('team')->get();
        $max_id = User::max('id');
        return view('teamManagement.create', ['users' => $users, 'max_id' => $max_id]);
    }

    public function show($id) {
        $team = Team::where('id', $id)->with(['logo', 'users', 'projects'])->firstOrFail();
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

    public function destroy(Request $request) {
        $request->validate([
            'id' => ['required', 'integer']
        ]);
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