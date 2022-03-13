@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row p-10">

        @if (Auth::user()->is_superuser)
            
            <div class="col-sm-12 col-md-3 mt-5">
                <a class="card-url" href="{{ route('userManagement') }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-users card-icon p-5"></i>
                                <p class="h3">User management</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        
        @if (!$teams->isEmpty())
            
            <div class="col-md-1 col-sm-12"></div>
            
            <div class="col-sm-12 col-md-3 mt-5">
                <a href="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-user-group card-icon p-5"></i>
                                <p class="h3">Team management</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        @endif
        
        @if (!$projects->isEmpty())
            <div class="col-md-1 col-sm-12"></div>

            <div class="col-sm-12 col-md-3 mt-5">
                <a href="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-diagram-project card-icon p-5"></i>
                                <p class="h3">Project management</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>

    @if (!$projects->isEmpty() || !$teams->isEmpty())
        <div class="row p-10">
            <div class="col-sm-12 col-md-3 mt-5">
                <a href="#">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-umbrella-beach card-icon p-5"></i>
                                <p class="h3">Vacation requests</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
