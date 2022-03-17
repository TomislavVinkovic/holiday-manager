<?php

namespace App\Http\Repositories\Projects;

use App\Http\Repositories\Projects\IProjectRepository;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Repositories\Images\AbsImageRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Project;

class ProjectRepository implements IProjectRepository {
    
    protected $imageRepository;

    public function __construct(AbsImageRepository $imageRepository) {
        $this->imageRepository = $imageRepository;
    }

    public function getProjectById(int $id, array $with = []) {
        $project = Project::where('id', $id)->with($with)->firstOrFail();
        if(Auth::user()->is_superuser || $project->lead_id == Auth::user()->id) {
            return $project;
        }
        else {
            abort(401);
        }
    }

    public function getProjects() {
        if(Auth::user()->is_superuser) {
            return Project::all();
        }
        else {
            $teams = Project::where('lead_id', Auth::user()->id)->get();
            return $teams;
        }
    }

    public function createProject(ProjectCreateRequest $request): Project {
        try {
            $logo = $this->imageRepository->createImage($request->logo);
            $project = Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'lead_id' => $request->lead,
                'logo_id' => $logo->id
            ]);
            return $project;

        } catch(Exception $e) {
            throw $e;
        }
        
    }

    public function patchProject(ProjectUpdateRequest $request): int {

        try {
            $project = $this->getProjectById($request->id, ['logo']);
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

        } catch(Exception $e) {
            throw $e;
        }

        
    }

    public function destroyProject(int $id): void {

        try {
            $project = $this->getProjectById($id);
            $this->imageRepository->destroyImage($project->logo_id);
            $project->delete();

        } catch(Exception $e) {
            
            throw $e;
        }
    }

    public function addTeamsToProject(int $project_id, array $teams): void {
        try {
            $project = $this->getProjectById($project_id);
            $project->teams()->attach($teams);
            $project->save();
        } catch (Exception $e) {
            throw $e;
        }
        
    }

    public function removeTeamFromProject(int $project_id, int $team_id): void {
        try {
            $project = $this->getProjectById($project_id);
            $project->teams()->detach($team_id);
            $project->save();
        } catch (Exception $e) {
            throw $e;
        }
    }
}