<?php

namespace App\Http\Repositories\Projects;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;

interface IProjectRepository {
    public function createProject(ProjectCreateRequest $request): Project;
    public function patchProject(ProjectUpdateRequest $request): int;
    public function destroyProject(int $id): void;
    public function addTeamToProject(int $project_id, int $team_id): void;
    public function removeTeamFromProject(int $project_id, int $team_id): void;
}