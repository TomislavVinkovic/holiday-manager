@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-md-2 col-sm-12"></div>
            <div class="col-md-8 col-sm-12">
                <form method="post" action="{{ route('vacationRequestManagement.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start date</label>
                        <input name="startDate" type="date" class="form-control" id="startDate" required />
                    </div>

                    <div class="mb-3">
                        <label for="endDate" class="form-label">End date</label>
                        <input name="endDate" type="date" class="form-control" id="endDate" required />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">I want to go on vacation!</button>
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