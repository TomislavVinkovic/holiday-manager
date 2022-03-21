@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row p-10">

        <ul class="list-group">
            @if (Auth::user()->is_superuser)
                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('userManagement') }}"> User management </a>
                    <i class="fa-solid fa-user-group card-icon p-3"></i>
                </li> 

                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('projectManagement') }}"> Project management </a>
                    <i class="fa-solid fa-diagram-project card-icon p-3"></i>
                </li> 

                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('teamManagement') }}"> Team management </a>
                    <i class="fa-solid fa-users card-icon p-3"></i>
                </li> 
            @endif

            @if (!$teams->isEmpty())
                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('teamManagement') }}"> My teams </a>
                    <i class="fa-solid fa-users card-icon p-3"></i>
                </li> 
            @endif

            @if (!$projects->isEmpty())
                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('projectManagement') }}"> My projects </a>
                    <i class="fa-solid fa-users card-icon p-3"></i>
                </li> 
            @endif

            @if (!$projects->isEmpty() || !$teams->isEmpty())
                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('vacationRequestManagement') }}"> Vacation requests </a>
                    <i class="fa-solid fa-umbrella-beach card-icon p-3"></i>
                </li> 
            @endif
            
            @if ($projects->isEmpty() && $teams->isEmpty() && !Auth::user()->is_superuser)
                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('vacationRequestManagement.create') }}">New vacation request</a>
                    <i class="fa-solid fa-plus card-icon p-3"></i>
                </li>
                
                <li class="list-group-item">
                    <a class="card-url h3" href="{{ route('vacationRequestManagement') }}">My vacation requests</a>
                    <i class="fa-solid fa-umbrella-beach card-icon p-3"></i>
                </li>
                
            @endif

        </ul>
    </div>
</div>
@endsection