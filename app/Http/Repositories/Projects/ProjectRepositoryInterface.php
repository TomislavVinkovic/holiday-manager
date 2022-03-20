<?php

namespace App\Http\Repositories\Projects;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use Illuminate\Support\Collection;
use App\Models\Project;

interface ProjectRepositoryInterface {
    public function getProjectById(int $id, array $with = []); //this function also checks if the user can access the team/project
    public function getProjectsForLead(): Collection; //this function also checks which projects the user can actually access
    public function getProjectsForSuperUser(): Collection;
    public function createProject(ProjectCreateRequest $request): Project;
    public function patchProject(ProjectUpdateRequest $request): int;
    public function destroyProject(int $id): void;
    public function addTeamsToProject(int $project_id, array $teams): void;
    public function removeTeamFromProject(int $project_id, int $team_id): void;
}