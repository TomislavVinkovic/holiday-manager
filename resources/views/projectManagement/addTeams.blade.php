@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-md-1 d-none d-md-block"></div>
            <div class="col-sm-12 col-md-9">
                <form action="{{ route('projectManagement.storeTeams') }}" method="post">

                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}" />
                    
                    @if (!$teams->isEmpty())
                        <label for="teams" class="form-label">Teams to add</label>

                        <select name="teams[]" id="teams" class="form-select" multiple>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}"> {{ $team->name }} </option>
                            @endforeach
                        </select>
                    @else
                        <span class="h3">No teams left to add!</span>
                    @endif
                    
                    @if (!$teams->isEmpty())
                        <button type="submit" class="btn btn-primary mt-5"> Add teams to {{ $project->name }} </button>
                    @endif
                    

                </form>
            </div>
        </div>
    </div>
@endsection