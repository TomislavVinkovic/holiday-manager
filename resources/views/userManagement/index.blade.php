@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-12">
                <div style="position: relative; max-height: 500px; overflow: auto; display:block;">
                    <table class="table table-striped">

                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>OIB</th>
                            <th>Username</th>
                            <th>Residence</th>
                            <th>E-mail</th>
                            <th>Roles</th>
                            <th></th>
                            <th></th>
                        </tr>
                        
                        @if($users->isEmpty())
                            <tr>
                                <td colspan="8">There are currently no users</td>
                            </tr>
                        @endif

                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->oib }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->residence }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    
                                    @if ($role !== $user->roles->last())
                                        {{ $role->role }},
                                    @else
                                        {{ $role->role }}
                                    @endif
                                @endforeach
                            </td>
                            <td><a class="btn btn-success" href="{{ route('userManagement.update', $user->id) }}">Edit</a></td>
                            <td>
                                <form method="post" action="{{ route('userManagement.destroy') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name='id' value={{ $user->id }}>
                                    <button type="submit" class="btn btn-danger" href="#">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
            <a class="btn btn-primary mt-5" href="{{ route('userManagement.create') }}">New user</a>
        </div>
    </div>
@endsection