@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row p-10">

            <div class="col-12">

                <h1>New vacation request</h1>

                <div class="d-block mt-5">
                    <span class="h4">Start date: </span>
                    <span class="d-inline"> {{ $vacationRequest->start_date }} </span>
                </div>

                <div class="d-block mt-3">
                    <span class="h4">End date: </span>
                    <span class="d-inline"> {{ $vacationRequest->end_date }} </span>
                </div>

                <div class="d-block mt-3">
                    <span class="h4">Description: </span>
                    <span class="d-block"> {{ $vacationRequest->description }} </span>
                </div>

                @if(Auth::user()->id !== $vacationRequest->user->id)
                    <form action="{{ route('vacationRequestManagement.approval') }}" method="post" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="vacationRequest" value="{{ $vacationRequest->id }}">
                        <input type="hidden" name="lead" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="approved" value="{{ true }}">
                        <button class="btn btn-success">Approve</button>
                    </form>

                    <form action="{{ route('vacationRequestManagement.approval') }}" method="post" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="vacationRequest" value="{{ $vacationRequest->id }}">
                        <input type="hidden" name="lead" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="approved" value="{{ false }}">
                        <button class="btn btn-danger">Decline</button>
                    </form>
                @endif

                <table class="table table-striped mt-5">
                    <tr>
                        <th>Lead</th>
                        <th>Approved?</th>
                    </tr>
                    @foreach ($vacationRequest->approvals as $approval)
                        @if ($approval->lead->id !== Auth::user()->id)
                            <tr>
                                <td>{{ $approval->lead->first_name }} {{ $approval->lead->last_name }}</td>
                                <td>
                                    @if ($approval->pending)
                                        <i class="fa-solid fa-hourglass" style="font-size: 20px" style="color: black"></i>
                                    @elseif (!$approval->pending && $approval->approved)
                                        <i class="fa-solid fa-check" style="font-size: 20px" style="color: green"></i>
                                    @else
                                        <i class="fa-solid fa-x" style="font-size: 20px" style="color: red"></i>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                @if ($vacationRequest->user_id === Auth::user()->id)
                    @if ($vacationRequest->approved && Carbon\Carbon::parse($vacationRequest->start_date)->lte(Carbon\Carbon::now()) && Carbon\Carbon::parse($vacationRequest->end_date)->gte(Carbon\Carbon::now()))
                        <div class="alert alert-success">
                            Hooray! You are on vacation right now! Log off and enjoy yourself!
                        </div>
                    @elseif($vacationRequest->approved)
                        <div class="alert alert-success">
                            Hooray! You are on vacation from {{ $vacationRequest->start_date }} to {{ $vacationRequest->end_date }}
                        </div>
                    @elseif(!$vacationRequest->approvals->where('approved', false)->isEmpty() && $vacationRequest->approvals->where('pending', true)->isEmpty())
                        <div class="alert alert-danger">
                            Your request was denied by some leads!
                        </div>
                    @elseif (!$vacationRequest->approvals->where('pending', true)->isEmpty())
                        <div class="alert alert-warning">
                            There are still some approvals that are pending.
                        </div>
                    @endif

                @endif
            </div>

        </div>
    </div>
@endsection