<?php

namespace App\Http\Repositories\VacationRequests;

use App\Http\Repositories\VacationRequests\IVacationRequestRepository;
use App\Models\VacationRequest;
use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\UpdateVacationRequestRequest;
use App\Http\Requests\VacationRequestApprovalRequest;
use Exception;
use App\Models\VacationRequestApproval;
use Illuminate\Support\Facades\Auth;

class VacationRequestRepository implements IVacationRequestRepository {

    public function getVacationRequestById(int $id): VacationRequest{
        try {
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

        } catch(Exception $e) {
            throw $e;
        }
    }

    //get all vacation requests assigned to this user
    public function getVacationRequests(): array{
        try {
            $vacationRequests = VacationRequest::whereHas('approvals', function ($q) {
                $q->where('lead_id', Auth::user()->id);
            })->get(); //za leadove
            $personalVacationRequests = VacationRequest::where('user_id', Auth::user()->id)->get();
            
            return [
                'requestsFromOthers' => $vacationRequests,
                'personalRequests' => $personalVacationRequests
            ];

        } catch(Exception $e) {
            throw $e;
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

    public function patchVacationRequest(UpdateVacationRequestRequest $request): VacationRequest{
        throw new Exception('Not implemented yet');
    }

    public function destroyVacationRequest(int $id): void{
        throw new Exception('Not implemented yet');
    }

    public function approveVacationRequest(VacationRequestApprovalRequest $request): void{
        $vacationRequest = $this->getVacationRequestById($request->vacationRequest);
        $vacationRequestApproval = $vacationRequest->approvals->filter(function ($item) {
            return $item->lead_id === Auth::user()->id;
        })->first();

        if(!$vacationRequestApproval) {
            abort(401);
        }

        //if the lead approves the request...
        if($request->approved) {
            $vacationRequestApproval->approved = true;
            $vacationRequestApproval->pending = false;
            $vacationRequestApproval->save();

            //if there are no requests left to approve
            if(!$vacationRequest->approvals->where('approved', 'false')) {
                $vacationRequest->approved = true;
                $vacationRequest->save();
            }
        }
        //else, if the lead declined the request
        else {
            $vacationRequestApproval->approved = false;
            $vacationRequestApproval->pending = false;
            $vacationRequestApproval->save();

            $vacationRequest->approved = false;
            $vacationRequest->save();
        }
    }

}