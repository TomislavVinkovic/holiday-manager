@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-md-2 col-sm-12"></div>
            <div class="col-md-8 col-sm-12">
                <form method="post" action="{{ route('userManagement.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="email" required />
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input name="username" type="text" class="form-control" id="username" required />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" required />
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Repeat password</label>
                        <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" required />
                    </div>

                    <div class="mb-3">
                        <label for="oib" class="form-label">OIB</label>
                        <input name="oib" type="text" class="form-control" id="oib" maxlength="11" required />
                    </div>

                    <div class="mb-3">
                        <label for="first_name" class="form-label">First name</label>
                        <input name="first_name" type="text" class="form-control" id="first_name" maxlength="100" required />
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last name</label>
                        <input name="last_name" type="text" class="form-control" id="last_name" maxlength="100" required />
                    </div>

                    <div class="mb-3">
                        <label for="residence" class="form-label">Residence</label>
                        <input name="residence" type="text" class="form-control" id="residence" maxlength="100" required />
                    </div>

                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of birth</label>
                        <input name="date_of_birth" type="date" class="form-control" id="date_of_birth" maxlength="100" required />
                    </div>

                    <button type="submit" class="btn btn-primary">Create user</button>
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