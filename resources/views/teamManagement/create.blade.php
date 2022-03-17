@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-md-2 col-sm-12"></div>
            <div class="col-md-8 col-sm-12">

                @if (!$project)
                    <h1>New Team</h1>
                @else
                    <h1>New Team for {{ $project->name }}</h1>
                @endif

                <form method="post" enctype="multipart/form-data" action="{{ route('teamManagement.store') }}">
                    @csrf

                    @if ($project !== null)
                        <input type="hidden" value="{{ $project->id }}" name="project" />
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" id="name" maxlength="255" required />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lead" class="form-label">Team lead</label>
                        <select class="form-select" name="lead" id="lead" onchange="disableOnMembers(event, {{ $max_id }})">
                            <option selected disabled>--Please, select a user--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="members" class="form-label">Members(other than the lead)</label>
                        <select class="form-select" name="members[]" id="members" multiple>
                            @foreach ($users as $user)
                                <option id="{{ $user->id }}" value="{{ $user->id }}"> {{ $user->first_name }} {{ $user->last_name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Team logo</label>
                        <input type="file" id="logo" name="logo" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Create team</button>
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

    <script>

    </script>

@endsection