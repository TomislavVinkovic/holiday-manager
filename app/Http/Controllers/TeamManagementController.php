<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Http\Requests\TeamCreateRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\TeamHasUser;
use App\Models\Image;
use Exception;

class TeamManagementController extends Controller
{
    public function __construct() {
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
        try{
            $valdiated = $request->validated();
            $logo_id = Image::uploadAndCreateGetId($request->logo);
            $team_id = Team::insertGetId([
                'name' => $request->name,
                'description' => $request->description,
                'lead_id' => $request->lead,
                'logo_id' => $logo_id
            ]);

            TeamHasUser::create([
                ['team_id' => $team_id, 'user_id' => $request->lead]
            ]);

            foreach($request->members as $member_id) {
                TeamHasUser::create(
                    ['team_id' => $team_id, 'user_id' => $member_id]
                );
            }

            return redirect(route('teamManagement'), 201);

        }catch(Exception $e) {
            throw $e;
        }
    }

    public function update($id) {
        $team = Team::where('id', $id)->with(['users', 'lead'])->firstOrFail();
        $otherUsers = User::doesntHave('team')->where('is_superuser', false)->get();
        $membersAndOthers = $otherUsers->concat($team->users);
        $max_id = User::max('id');
        return view('teamManagement.update', ['team' => $team, 'allUsers' => $membersAndOthers, 'others' => $otherUsers, 'max_id' => $max_id]);
    }

    public function patch(TeamUpdateRequest $request) {
        try {
            $validated = $request->validated();
            $team = Team::where('id', $request->id)->with('users')->firstOrFail();
            $team->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            if((int)$request->lead !== $team->lead_id) {
                $teamHasLead = TeamHasUser::where([
                    'team_id' => $team->id,
                    'user_id' => $team->lead_id
                ])->firstOrFail();
                $teamHasLead->delete();
                
                TeamHasUser::create([
                    'team_id' => $team->id, 'user_id' => $request->lead
                ]);

                $team->lead_id = $request->lead;
                $team->save();
            }

            if($request->members !== null) {
                foreach($request->members as $member_id) {
                    TeamHasUser::create([
                        'team_id' => $team->id, 'user_id' => $member_id
                    ]);
                }
            }

            if($request->logo !== null) { //ovo imam i kod projekta, znam.. to cu rjesiti kad uvedem repository pattern kasnije :)
                Storage::delete($team->logo->file_path);
                $old_img = $team->logo_id;
                $team->logo_id = Image::uploadAndCreateGetId($request->logo);
                $team->save();
                Image::destroy($old_img);
            }

            return $this->show($team->id);
            die;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy(Request $request) {
        try {
            $request->validate([
                'id' => ['required', 'integer']
            ]);
            
            Team::destroy($request->id);
            return redirect(route('teamManagement'));
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function removeMember($id) {
        return;
    }
}
