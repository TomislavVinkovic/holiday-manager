<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Team;

class HomeController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        
        $teams = Team::where('lead_id', '=', Auth::user()->id)->get();
        $projects = Project::where('lead_id', '=',  Auth::user()->id)->get();
        
        return view(
            'home',
            [
                'teams' => $teams,
                'projects' => $projects    
            ]
        );
    }
}
