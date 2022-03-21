<?php

namespace App\Http\Repositories\Projects;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Repositories\Projects\ProjectRepositoryInterface;
use App\Http\Repositories\Images\ImageRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\DisallowedDeletionException;
use App\Models\Project;
use Illuminate\Support\Collection;

class ProjectRepository implements ProjectRepositoryInterface {

    public function __construct(protected ImageRepositoryInterface $imageRepository) {}

    public function getProjectById(int $id, array $with = []) {
        $project = Project::where('id', $id)->with($with)->firstOrFail();
        if(Auth::user()->is_superuser || $project->lead_id == Auth::user()->id) {
            return $project;
        }
        else {
            abort(401);
        }
    }

    public function getProjectsForSuperUser(): Collection {
        return Project::all();
    }

    public function getProjectsForlead(): Collection {
        return Project::where('lead_id', Auth::user()->id)->get();
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

        $project = $this->getProjectById($request->id, ['logo']);

        $project->name = $request->name;
        $project->description =  $request->description;
        $project->lead_id = $request->lead;
        
        if($project->isDirty()) {
            $project->update();
        }

        if($request->logo !== null) {
            $newLogo = $this->imageRepository->updateImage($request->logo, $project->logo_id);
            $project->logo_id = $newLogo->id;
            $project->save();
        }

        return $project->id;
        
    }

    public function destroyProject(int $id): void {
        $project = $this->getProjectById($id);
        $this->imageRepository->destroyImage($project->logo_id);
        $project->delete();
    }

    public function addTeamsToProject(int $project_id, array $teams): void {
        $project = $this->getProjectById($project_id);
        $project->teams()->attach($teams);
        $project->save();
        
    }

    public function removeTeamFromProject(int $project_id, int $team_id): void {
        //test example
        $path = explode('\\', Team::class); //puno ime klase, da kasnije mogu dobiti skracenu verziju
        if($team_id === 7) {
            throw new DisallowedDeletionException(array_pop($path));
        }
        $project = $this->getProjectById($project_id);
        $project->teams()->detach($team_id);
        $project->save();
    }
}