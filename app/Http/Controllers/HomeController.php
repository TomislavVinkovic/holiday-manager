<?php

namespace App\Http\Controllers;



use App\Http\Repositories\Projects\ProjectRepositoryInterface;
use App\Http\Repositories\Teams\TeamRepositoryInterface;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected ProjectRepositoryInterface $projectRepository
    ) {
        $this->middleware('auth');
    }

    public function index() {
        
        $teams = $this->teamRepository->getTeamsForLead();
        $projects = $this->projectRepository->getProjectsForLead();
        
        return view(
            'home',
            [
                'teams' => $teams,
                'projects' => $projects    
            ]
        );
    }
}
