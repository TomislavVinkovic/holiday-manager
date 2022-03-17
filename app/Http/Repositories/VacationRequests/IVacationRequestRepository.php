<?php

namespace App\Http\Repositories\VacationRequests;

use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\UpdateVacationRequestRequest;

interface IVacationRequestRepository {

    public function getVacationRequestById(int $id);
    public function getVacationRequests(); //filtered by user access
    public function createVacationRequest(CreateVacationRequestRequest $request);
    public function patchVacationRequest(UpdateVacationRequestRequest $request);
    public function destroyVacationRequest(int $id);
    public function approveVacationRequest(int $id);
    
} 