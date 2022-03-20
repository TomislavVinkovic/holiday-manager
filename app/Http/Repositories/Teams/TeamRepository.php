<?php

namespace App\Http\Repositories\Teams;

use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Http\Repositories\Teams\TeamRepositoryInterface;
use App\Http\Repositories\Users\UserRepositoryInterface;
use App\Models\Team;
use App\Http\Repositories\Images\ImageRepositoryInterface;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Exception;

class TeamRepository implements TeamRepositoryInterface {

    public function __construct(
        protected ImageRepositoryInterface $imageRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function getTeamById(int $id, array $with = []): Team {
        $team = Team::where('id', $id)->with($with)->firstOrFail();
        if(Auth::user()->is_superuser || $team->lead_id === Auth::user()->id) {
            return $team;
        }
        else {
            abort(401);
        }
    }

    public function getTeamsForSuperUser(): Collection {
        return Team::all();
    }

    public function getTeamsForLead(): Collection {
        return Team::where('lead_id', Auth::user()->id)->get();
    }

    public function getTeamsNotInProject(Project $project) {
        $teams = Team::whereDoesntHave('projects', function ($q) use ($project) {
            $q->where('projects.id', '=', $project->id);
        })->get();
        return $teams;
    }

    public function getUpdateInformation(int $id): array {
        try {
            $team = $this->getTeamById($id, ['users']);
            $otherUsers = $this->userRepository->getUsersWithNoTeam();
            $membersAndOthers = $otherUsers->concat($team->users);
            $max_id = $this->userRepository->getMaxId();
            
            return ['team' => $team, 'allUsers' => $membersAndOthers, 'others' => $otherUsers, 'max_id' => $max_id];

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createTeamWithMembers(TeamCreateRequest $request): Team {
        try {
            $logo = $this->imageRepository->createImage($request->logo);
            $team = Team::create([
                'name' => $request->name,
                'description' => $request->description,
                'lead_id' => $request->lead,
                'logo_id' => $logo->id
            ]);
            $team->users()->attach($request->lead);
            $team->users()->attach($request->members);

            if(!$request->project) {
                $team->save();
            }
            else {
                $team->projects()->attach($request->project);
                $team->save();
            }
            return $team;

        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function patchTeam(TeamUpdateRequest $request): int {
        
        try {
            
            $team = $this->getTeamById($request->id, ['users', 'logo']);
            $team->name = $request->name;
            $team->description = $request->description;
            if($team->isDirty()) {
                $team->update();
            }

            if((int)$request->lead !== $team->lead_id) {
                if(!$team->users->contains($request->lead)) {
                    $team->users()->attach($request->lead);
                }
                $team->lead_id = $request->lead;
            }

            if($request->members !== null) {
                $team->users()->attach($request->members);
            }

            if($request->logo !== null) {
                $newLogo = $this->imageRepository->updateImage($request->logo, $team->logo_id);
                $team->logo_id = $newLogo->id;
            }
            $team->save();

            return $team->id;

        } catch (Exception $e) {
            throw $e;
        }

    }


    public function destroyTeamById(int $id): void {
        try {
            $team = Team::findOrFail($id);
            $team->users()->detach();
            $team->projects()->detach();
            $this->imageRepository->destroyImage($team->logo_id);
            $team->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function removeMember(int $team_id, int $user_id): int {
        $team = Team::findOrFail($team_id);
        $team->users()->detach($user_id);
        return $team->id;
    }
}