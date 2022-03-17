@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row p-10">
            <div class="col-12">
                <div class="table-div">
                    <table class="table table-striped">

                        <tr>
                            <th>No.</th>
                            <th>User</th>
                            <th>Start date</th>
                            <th>End date</th>
                        </tr>
                        
                        @if($vacationRequests->isEmpty())
                            <tr>
                                <td colspan="8">There are currently no vacation requests from employees. That means that everyone is super productive!</td>
                            </tr>
                        @endif

                        @foreach ($vacationRequests as $vacationRequest)
                        <tr>
                            <td> {{ $vacationRequest->id }} </td>
                            <td>{{ $vacationRequest->user->first_name }} {{ $vacationRequest->user->last_name }}</td>
                            <td>{{ $vacationRequest->start_date }}</td>
                            <td>{{ $vacationRequest->end_date }}</td>
                            <td><a class="btn btn-success" href="{{ route('userManagement.update', $user->id) }}">Edit</a></td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection