<?php

namespace App\Http\Repositories\Projects;

use App\Http\Repositories\Projects\IProjectRepository;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Repositories\Images\AbsImageRepository;
use App\Models\Image;
use App\Models\Project;

class ProjectRepository implements IProjectRepository {
    
    protected $imageRepository;

    public function __construct(AbsImageRepository $imageRepository) {
        $this->imageRepository = $imageRepository;
    }

    public function createProject(ProjectCreateRequest $request): Project {
        $logo = $this->imageRepository->createImage($request->logo);
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'lead_id' => $request->lead,
            'logo_id' => $logo->id
        ]);
        return $project;
    }

    public function patchProject(ProjectUpdateRequest $request): int {
        $project = Project::where('id', $request->id)->with('logo')->firstOrFail();
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'lead_id' => $request->lead
        ]);
        if($request->logo !== null) {
            $newLogo = $this->imageRepository->updateImage($request->logo, $project->logo_id);
            $project->logo_id = $newLogo->id;
            $project->save();
        }

        return $project->id;
    }

    public function destroyProject(int $id): void {
        $project = Project::findOrFail($id);
        $this->imageRepository->destroyImage($project->logo_id);
        $project->delete();
    }

    public function addTeamToProject(int $project_id, int $team_id): void {
        return;
    }

    public function removeTeamFromProject(int $project_id, int $team_id): void {
        return;
    }
}