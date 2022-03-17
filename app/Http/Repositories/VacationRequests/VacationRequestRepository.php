<?php

namespace App\Http\Repositories\VacationRequests;

use App\Http\Repositories\VacationRequests\IVacationRequestRepository;
use App\Models\VacationRequest;
use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\UpdateVacationRequestRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class VacationRequestRepository implements IVacationRequestRepository {

    public function getVacationRequestById(int $id){
        try {
            $vacationRequest = VacationRequest::findOrFail($id);
            $vacationRequestApprovalFilter = $vacationRequest->approvals->filter(function ($item) {
                return $item->user_id === Auth::user()->id;
            })->first();
            if(!$vacationRequestApprovalFilter) {
                abort(401); //to znaci da korisnik nema pravo pristupiti ovom requestu
            }
            else {
                return $vacationRequest;
            }

        } catch(Exception $e) {
            throw $e;
        }
    }

    //get all vacation requests assigned to this user
    public function getVacationRequests(){
        try {
            $vacationRequests = VacationRequest::whereHas('approvals', function ($q) {
                $q->where('lead_id', Auth::user()->id);
            })->get();
            return $vacationRequests;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function createVacationRequest(CreateVacationRequestRequest $request){
        $team = Auth::user()->team->first();
        $projects = $team->projects;
        //kreiraj nove approval requestove i novi vacation request
    }

    public function patchVacationRequest(UpdateVacationRequestRequest $request){
        return;
    }

    public function destroyVacationRequest(int $id){
        return;
    }

    public function approveVacationRequest(int $id){
        return;
    }

}