@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-sm-12 col-md-4">
                <img class="img-fluid w-25" src="{{ Storage::url($project->logo->file_path) }}">
                <span class="h3">{{ $project->name }}</span>
            </div>
        </div>

        <div class="row p-10 mt-5">
            <div class="col-12">
                <span class="h4"><strong>Lead: </strong></span> <span class="h4"> {{ $project->lead->first_name }} {{ $project->lead->last_name }}</span>
            </div>
        </div>

        <div class="row p-10 mt-5">
            <div class="col-12">
                <blockquote class="blockquote">
                    <p>{{ $project->description }}</p>
                </blockquote>
            </div>
        </div>

        <div class="row p-10 mt-2">
            <div class="col-sm-12 col-md-2">
                <a class="btn btn-success" href="{{ route('projectManagement.update', $project->id) }}">Manage project</a>
            </div>
            <div class="col-sm-12 col-md-2">
                <form method="post" action="{{ route('projectManagement.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name='id' value={{ $project->id }}>
                    <button type="submit" class="btn btn-danger">Delete project</button>
                </form>
            </div>
        </div>

        <div class="row p-10 mt-5">
            <div class="col-sm-12 col-md-1">
                <span><strong>Teams:</strong></span>
            </div>
            <div class="col-sm-12 col-md-11">
                <ul class="list-group list-group-horizontal flex-fill">
                    @if ($project->teams->isEmpty())
                        <li class="list-group-item"> This project currently has no teams assigned to it</li>
                    @else
                        @foreach ($teams as $team)
                            <li class="list-group-item"> {{ $team->name }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="row p-10 mt-4">
            <div class="col-md-1 d-none d-md-block"></div>
            <div class="col-sm-12 col-md-3">
                <a class="btn btn-primary" href="#">Create a new team for this project</a>
            </div>
            <div class="col-sm-12 col-md-3">
                <a class="btn btn-secondary" href="#">Add an existing team</a>
            </div>
        </div>

    </div>
    

@endsection