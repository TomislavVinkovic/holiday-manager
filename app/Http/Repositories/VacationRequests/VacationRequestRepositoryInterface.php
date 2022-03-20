<?php

namespace App\Http\Repositories\VacationRequests;

use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\UpdateVacationRequestRequest;
use App\Http\Requests\VacationRequestApprovalRequest;
use App\Models\VacationRequest;

interface VacationRequestRepositoryInterface {

    public function getVacationRequestById(int $id): VacationRequest;
    public function getVacationRequests(): array; //filtered by user access
    public function createVacationRequest(CreateVacationRequestRequest $request): VacationRequest;
    public function getCreateData(): array;
    public function approveVacationRequest(VacationRequestApprovalRequest $request): void;
    
} 