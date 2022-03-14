@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-md-2 col-sm-12"></div>
            <div class="col-md-8 col-sm-12">
                <form method="post" action="{{ route('userManagement.patch') }}">
                    @csrf
                    @method('patch')

                    <input type="hidden" id='id' value="{{ $user->id }}" name='id'>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input name="email" value="{{ $user->email }}" type="email" class="form-control" id="email" required />
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input name="username" value="{{ $user->username }}" type="text" class="form-control" id="username" required />
                    </div>

                    <div class="mb-3">
                        <label for="oib" class="form-label">OIB</label>
                        <input name="oib" value="{{ $user->oib }}" type="text" class="form-control" id="oib" maxlength="11" required />
                    </div>

                    <div class="mb-3">
                        <label for="first_name" class="form-label">First name</label>
                        <input name="first_name" value="{{ $user->first_name }}" type="text" class="form-control" id="first_name" maxlength="100" required />
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last name</label>
                        <input name="last_name" value="{{ $user->last_name }}" type="text" class="form-control" id="last_name" maxlength="100" required />
                    </div>

                    <div class="mb-3">
                        <label for="residence" class="form-label">Residence</label>
                        <input name="residence" value="{{ $user->residence }}" type="text" class="form-control" id="residence" maxlength="100" required />
                    </div>

                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of birth</label>
                        <input name="date_of_birth" value="{{ $user->date_of_birth }}" type="date" class="form-control" id="date_of_birth" maxlength="100" required />
                    </div>

                    <div class="mb-3">
                        <label for="roles" class="form-label">Roles(select at least one)</label>
                        <select class="form-select" name="roles[]" id="roles" multiple="multiple">
                            @foreach ($roles as $role)
                                @if ($user->roles->contains($role->id))
                                    <option value="{{ $role->id }}" selected>{{ $role->role }}</option>
                                @else
                                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update user data</button>
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