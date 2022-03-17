<?php

namespace App\Http\Repositories\Projects;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;

interface IProjectRepository {
    public function getProjectById(int $id, array $with = []); //this function also checks if the user can access the team/project
    public function getProjects(); //this function also checks which projects the user can actually access
    public function createProject(ProjectCreateRequest $request): Project;
    public function patchProject(ProjectUpdateRequest $request): int;
    public function destroyProject(int $id): void;
    public function addTeamsToProject(int $project_id, array $teams): void;
    public function removeTeamFromProject(int $project_id, int $team_id): void;
}