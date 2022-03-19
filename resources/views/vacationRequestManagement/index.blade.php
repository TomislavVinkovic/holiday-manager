@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row p-10">
            <h1>Vacation requests</h1>
            <div class="col-12">
                @if(!$requestsFromOthers->isEmpty())
                    <div class="table-div">
                        <h1>Vacation requests from employees</h1>
                        <table class="table table-striped">
                            <tr>
                                <th>No.</th>
                                <th>User</th>
                                <th>Start date</th>
                                <th>End date</th>
                            </tr>
                            

                            @foreach ($requestsFromOthers as $vacationRequest)
                            
                                <tr>
                                    <td> {{ $vacationRequest->id }} </td>
                                    
                                        <td>
                                            <a href="{{ route('vacationRequestManagement.show', $vacationRequest->id) }}" style="text-decoration: none; color: black;"> 
                                                {{ $vacationRequest->user->first_name }} {{ $vacationRequest->user->last_name }}
                                            </a>
                                        </td>
                                    </a>
                                    <td>{{ $vacationRequest->start_date }}</td>
                                    <td>{{ $vacationRequest->end_date }}</td>
                                </tr>
                            
                            @endforeach

                        </table>
                    </div>
                @endif
                
                @if(!$personalRequests->isEmpty())
                    <div class="table-div mt-5">
                        <h1>Personal vacation requests</h1>
                        <table class="table table-striped">
                            <tr>
                                <th>No.</th>
                                <th>Start date</th>
                                <th>End date</th>
                            </tr>
                            

                            @foreach ($personalRequests as $vacationRequest)
                            <tr>
                                <td> <a href="{{ route('vacationRequestManagement.show', $vacationRequest->id) }}">{{ $vacationRequest->id }} </a></td>
                                <td>{{ $vacationRequest->start_date }}</td>
                                <td>{{ $vacationRequest->end_date }}</td>
                            </tr>
                            @endforeach

                        </table>

                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection