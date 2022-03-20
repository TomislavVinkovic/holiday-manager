<?php

namespace App\Http\Controllers;
use App\Http\Repositories\VacationRequests\VacationRequestRepositoryInterface;
use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\VacationRequestApprovalRequest;
use App\Http\Requests\UpdateVacationRequestRequest;

class VacationRequestManagementController extends Controller {
    
    public function __construct(
        protected VacationRequestRepositoryInterface $vacationRequestRepository
    ) {
        $this->middleware('notsuperuser');
    }

    public function index() {
        $vacationRequests = $this->vacationRequestRepository->getVacationRequests();
        return view('vacationRequestManagement.index', $vacationRequests);
    }

    public function show($id) {
        $vacationRequest = $this->vacationRequestRepository->getVacationRequestById($id);
        return view('vacationRequestManagement.show', [
            'vacationRequest' => $vacationRequest,
        ]);
    }

    public function create() {
        $data = $this->vacationRequestRepository->getCreateData();
        return view('vacationRequestManagement.create', $data);
    }

    public function store(CreateVacationRequestRequest $request) {
        $validated = $request->validated();
        $vacationRequest = $this->vacationRequestRepository->createVacationRequest($request);
        return redirect(route('vacationRequestManagement.show', $vacationRequest->id));
    }

    public function approve(VacationRequestApprovalRequest $request) {
        $validated = $request->validated();
        $this->vacationRequestRepository->approveVacationRequest($request);
        return redirect(route('vacationRequestManagement'));
    }
}
