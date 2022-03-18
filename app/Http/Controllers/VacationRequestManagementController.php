<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\VacationRequests\IVacationRequestRepository;
use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\VacationRequestApprovalRequest;
use App\Http\Requests\UpdateVacationRequestRequest;

class VacationRequestManagementController extends Controller {
    
    public function __construct(protected IVacationRequestRepository $vacationRequestRepository) {}

    public function index() {
        $vacationRequests = $this->vacationRequestRepository->getVacationRequests();
        return view('vacationRequestManagement.index', $vacationRequests);
    }

    public function show($id) {
        $vacationRequest = $this->vacationRequestRepository->getVacationRequestById($id);
        return view('vacationRequestManagement.show', ['vacationRequest' => $vacationRequest]);
    }

    public function create() {
        return view('vacationRequestManagement.create');
    }

    public function store(CreateVacationRequestRequest $request) {
        $validated = $request->validated();
        $vacationRequest = $this->vacationRequestRepository->createVacationRequest($request);
        return redirect(route('vacationRequestManagement.show', $vacationRequest->id));
    }

    public function update($id) {
        return;
    }

    public function patch() {
        return;
    }

    public function destroy() {
        return;
    }

    public function approve(VacationRequestApprovalRequest $request) {
        $validated = $request->validated();
        $this->vacationRequestRepository->approveVacationRequest($request);
        return redirect(route('vacationRequestManagement.show', $request->vacationRequest));
    }
}
