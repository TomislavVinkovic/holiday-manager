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
                    
                    @if($teams->isEmpty())
                        <tr>
                            <td colspan="8">There are currently no teams</td>
                        </tr>
                    @endif

                    @foreach ($teams as $team)
                    <tr>
                        <td><a class="table-url" href="{{ route('teamManagement.show', $team->id) }}">{{ $team->name }}</a></td>
                        <td>{{ $team->lead->first_name }} {{ $team->lead->last_name }}</td>
                    </tr>
                    @endforeach

                </table>
            </div>
            <a class="btn btn-primary mt-5" href="{{ route('teamManagement.create') }}">New team</a>
        </div>
    </div>
</div>
@endsection