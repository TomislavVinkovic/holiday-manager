<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Cmixin\BusinessDay;

class AppServiceProvider extends ServiceProvider
{   

    public function register() {
        $this->app->bind('App\Http\Repositories\Users\UserRepositoryInterface', 'App\Http\Repositories\Users\UserRepository');
        $this->app->bind('App\Http\Repositories\Teams\TeamRepositoryInterface', 'App\Http\Repositories\Teams\TeamRepository');
        $this->app->bind('App\Http\Repositories\Projects\ProjectRepositoryInterface', 'App\Http\Repositories\Projects\ProjectRepository');
        $this->app->bind('App\Http\Repositories\Images\ImageRepositoryInterface', 'App\Http\Repositories\Images\ImageRepository');
        $this->app->bind('App\Http\Repositories\VacationRequests\VacationRequestRepositoryInterface', 'App\Http\Repositories\VacationRequests\VacationRequestRepository');
    }

    private function and($b1, $b2) {
        return $b1 && $b2;
    }

    public function boot() {

        BusinessDay::enable('Illuminate\Support\Carbon');
        
        Validator::extend('integer_array', function ($attribute, $arr, $parameters, $validator) {
            if (array_reduce(array_map('is_numeric', $arr), 'self::and' , True) == False) return false;
            else {
                return array_reduce(
                    array_map(function ($item) {
                        return is_int($item + 0);
                    }, $arr), 'self::and' , True);
            }
        });

    }
}
