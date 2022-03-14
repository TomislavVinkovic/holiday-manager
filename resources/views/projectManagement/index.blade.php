@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row p-10">
        <div class="col-12">
            <div style="position: relative; max-height: 500px; overflow: auto; display:block;">
                <table class="table table-striped">

                    <tr>
                        <th>Name</th>
                        <th>Lead</th>
                        <th></th>
                        <th></th>
                    </tr>
                    
                    @if($projects->isEmpty())
                        <tr>
                            <td colspan="8">There are currently no projects</td>
                        </tr>
                    @endif

                    @foreach ($projects as $project)
                    <tr>
                        <td><a class="table-url" href="{{ route('projectManagement.show', $project->id) }}">{{ $project->name }}</a></td>
                        <td>{{ $project->lead->first_name }} {{ $project->lead->last_name }}</td>
                    </tr>
                    @endforeach

                </table>
            </div>
            <a class="btn btn-primary mt-5" href="{{ route('projectManagement.create') }}">New project</a>
        </div>
    </div>
</div>
@endsection