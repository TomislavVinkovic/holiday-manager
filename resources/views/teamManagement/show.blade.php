@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-sm-12 col-md-4">
                <img class="img-fluid w-25" src="{{ Storage::url($team->logo->file_path) }}">
                <span class="h3">{{ $team->name }}</span>
            </div>
        </div>

        <div class="row p-10 mt-5">
            <div class="col-12">
                <span class="h4"><strong>Lead: </strong></span> <span class="h4"> {{ $team->lead->first_name }} {{ $team->lead->last_name }}</span>
            </div>
        </div>

        <div class="row p-10 mt-5">
            <div class="col-12">
                <blockquote class="blockquote">
                    <p>{{ $team->description }}</p>
                </blockquote>
            </div>
        </div>

        <div class="row p-10 mt-2">
            <div class="col-sm-12 col-md-2">
                <a class="btn btn-success" href="{{ route('teamManagement.update', $team->id) }}">Manage team</a>
            </div>
            <div class="col-sm-12 col-md-2">
                <form method="post" action="{{ route('teamManagement.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name='id' value={{ $team->id }}>
                    <button type="submit" class="btn btn-danger">Delete team</button>
                </form>
            </div>
        </div>

        <div class="row p-10 mt-5">
            <div class="col-12">
                <div class="table-div">
                    <table class="table table-striped">
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Roles</th>
                            <th></th>
                        </tr>

                        @if ($team->users->isEmpty())
                            <td colspan="4"> This team currently has no members assigned to it</li>
                        @else
                            @foreach ($team->users as $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        @if ($role !== $user->roles->last())
                                            {{ $role->role }},
                                        @else
                                            {{ $role->role }}
                                        @endif
                                    @endforeach
                                </td>
                                
                                <td>
                                    <form method="post" action="{{ route('teamManagement.removeMember') }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name='team_id' value={{ $team->id }}>
                                        <input type="hidden" name='user_id' value={{ $user->id }}>
                                        <button type="submit" class="btn btn-danger" href="#">Remove from team</button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>
    

@endsection