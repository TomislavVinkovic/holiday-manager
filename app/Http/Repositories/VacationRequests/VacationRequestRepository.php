<?php

namespace App\Http\Repositories\VacationRequests;

use App\Events\VacationRequestApprovalApprovedEvent;
use App\Http\Repositories\VacationRequests\VacationRequestRepositoryInterface;
use App\Models\VacationRequest;
use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\VacationRequestApprovalRequest;
use Exception;
use App\Models\VacationRequestApproval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class VacationRequestRepository implements VacationRequestRepositoryInterface {

    public function getVacationRequestById(int $id): VacationRequest{
        $vacationRequest = VacationRequest::findOrFail($id);

        $leadVacationRequestApprovalFilter = $vacationRequest->approvals->filter(function ($item) {
            return $item->lead_id === Auth::user()->id;
        })->first(); //if the user is a lead, does he/she hold rights to access this request?

        if(!$leadVacationRequestApprovalFilter) {
            if($vacationRequest->user->id === Auth::user()->id) {
                return $vacationRequest; //if the user is an employee, or the maker of the request, does he/she hold rights to access this request?
            }
            else {                  
                abort(401);
            }
        }
        else {
            return $vacationRequest;
        }
    }

    //get all vacation requests assigned to this user
    public function getVacationRequests(): array{
        $vacationRequests = VacationRequest::whereHas('approvals', function ($q) {
            $q->where('lead_id', Auth::user()->id);
            $q->where('pending', true);
        })->get(); //za leadove
        $personalVacationRequests = VacationRequest::where('user_id', Auth::user()->id)->get();
        
        return [
            'requestsFromOthers' => $vacationRequests,
            'personalRequests' => $personalVacationRequests
        ];

    }

    public function getCreateData(): array {
        $activeRequest = VacationRequest::where('user_id', Auth::user()->id)
                                ->where('approved', true)->latest()->first();
        if(!$activeRequest) {
            return [
                'on_vacation' => false,
            ];
        }
        else {
            return [
                'on_vacation' => true,
            ];
        }
    }

    public function createVacationRequest(CreateVacationRequestRequest $request): VacationRequest{
        $team = Auth::user()->team->first();
        $projects = $team->projects;

        $vacationRequest = VacationRequest::create([
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'approved' => false,
            'description' => $request->description,
            'user_id' => Auth::user()->id
        ]);

        $vacationRequestApprovalTeamLead = VacationRequestApproval::create([
            'vacation_request_id' => $vacationRequest->id,
            'lead_id' => $team->lead->id
        ]);

        $vacationRequestApprovalTeamLead->vacationRequest()->associate($vacationRequest);
        $vacationRequestApprovalTeamLead->save();

        foreach($projects as $project) {
            $vacationRequestApprovalProjectLead = VacationRequestApproval::create([
                'vacation_request_id' => $vacationRequest->id,
                'lead_id' => $project->lead->id
            ]);
            $vacationRequestApprovalProjectLead->vacationRequest()->associate($vacationRequest);
            $vacationRequestApprovalProjectLead->save();
        }

        return $vacationRequest;
    }

    public function approveVacationRequest(VacationRequestApprovalRequest $request): void{
        $vacationRequest = $this->getVacationRequestById($request->vacationRequest);
        $vacationRequestApproval = $vacationRequest->approvals->filter(function ($item) {
            return $item->lead_id === Auth::user()->id;
        })->first();

        if(!$vacationRequestApproval) {
            abort(401);
        }
        VacationRequestApprovalApprovedEvent::dispatch($vacationRequestApproval, $vacationRequest, $request->approved);
    }
}