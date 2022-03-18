<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Teams\ITeamRepository;
use App\Http\Repositories\Projects\IProjectRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Team;

class HomeController extends Controller
{

    public function __construct(
        protected ITeamRepository $teamRepository,
        protected IProjectRepository $projectRepository
    ) {
        $this->middleware('auth');
    }

    public function index() {
        
        $teams = $this->teamRepository->getTeams();
        $projects = $this->projectRepository->getProjects();
        
        return view(
            'home',
            [
                'teams' => $teams,
                'projects' => $projects    
            ]
        );
    }
}
