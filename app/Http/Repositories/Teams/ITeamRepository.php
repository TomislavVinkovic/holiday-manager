<?php

namespace App\Http\Repositories\Teams;

use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\User;
use App\Models\Team;

interface ITeamRepository {
    public function getTeamById(int $id, array $with = []); //this function also checks if the user can access the team/project
    public function getTeams(); //this also function checks which teams the user can actually access
    public function getUpdateInformation(int $id): array;
    public function createTeamWithMembers(TeamCreateRequest $request): Team;
    public function patchTeam(TeamUpdateRequest $request): int;
    public function removeMember(int $team_id, int $user_id): int;
    public function destroyTeamById(int $id): void;
}