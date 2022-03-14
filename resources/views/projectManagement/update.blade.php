@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-md-2 col-sm-12"></div>
            <div class="col-md-8 col-sm-12">

                <h1>Update {{ $project->name }}</h1>

                <form method="post" enctype="multipart/form-data" action="{{ route('projectManagement.patch') }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" value="{{ $project->id }}" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" id="name" maxlength="255" value="{{ $project->name }}" required />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $project->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lead" class="form-label">Project lead</label>
                        <select class="form-select" name="lead" id="lead" required>
                            @foreach ($users as $user)
                                @if ($project->lead == $user)
                                    <option value="{{ $user->id }}" selected>{{ $user->first_name }} {{ $user->last_name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Project logo</label>
                        <input type="file" id="logo" name="logo" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Update project</button>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach 
                        </ul>
                    </div>                   
                @endif
            </div>
            <div class="col-md-2 col-sm-12"></div>
        </div>
    </div>
@endsection