<?php

namespace App\Http\Repositories\Teams;

use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Http\Repositories\Teams\ITeamRepository;
use App\Models\Image;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Repositories\Images\AbsImageRepository;
use Exception;

class TeamRepository implements ITeamRepository {

    protected $imageRepository;

    public function __construct(AbsImageRepository $imageRepository) {
        $this->imageRepository = $imageRepository;
    }

    public function getUpdateInformation(int $id): array {
        try {

            $team = Team::where('id', $id)->with(['users', 'lead'])->firstOrFail();
            $otherUsers = User::doesntHave('team')->where('is_superuser', false)->get();
            $membersAndOthers = $otherUsers->concat($team->users);
            $max_id = User::max('id');
            
            $data = ['team' => $team, 'allUsers' => $membersAndOthers, 'others' => $otherUsers, 'max_id' => $max_id];
            return $data;

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createTeamWithMembers(TeamCreateRequest $request): Team {

        try {
            //kreiranje slike cu napraviti preko repozitorija
            $logo = $this->imageRepository->createImage($request->logo);
            $team = Team::create([
                'name' => $request->name,
                'description' => $request->description,
                'lead_id' => $request->lead,
                'logo_id' => $logo->id
            ]);
            $team->users()->attach($request->lead);
            $team->users()->attach($request->members);
            $team->save();

            return $team;

        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function patchTeam(TeamUpdateRequest $request): int {
        
        try {
            
            $team = Team::where('id', $request->id)->with(['users', 'logo'])->firstOrFail();
            $team->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            if((int)$request->lead !== $team->lead_id) {
                $team->users()->attach($request->lead);
                $team->lead_id = $request->lead;
            }

            if($request->members !== null) {
                $team->users()->attach($request->members);
            }

            if($request->logo !== null) {
                $newLogo = $this->imageRepository->updateImage($request->logo, $team->logo_id);
                $team->logo_id = $newLogo->id;
                $team->save();
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