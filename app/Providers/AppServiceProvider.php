<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register() {
        $this->app->bind('App\Http\Repositories\Users\IUserRepository', 'App\Http\Repositories\Users\UserRepository');
        $this->app->bind('App\Http\Repositories\Teams\ITeamRepository', 'App\Http\Repositories\Teams\TeamRepository');
        $this->app->bind('App\Http\Repositories\Projects\IProjectRepository', 'App\Http\Repositories\Projects\ProjectRepository');
        $this->app->bind('App\Http\Repositories\Images\AbsImageRepository', 'App\Http\Repositories\Images\ImageRepository');
    }

    public function boot()
    {
        
    }
}
