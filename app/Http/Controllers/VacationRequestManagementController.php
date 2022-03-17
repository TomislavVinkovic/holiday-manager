<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\VacationRequests\IVacationRequestRepository;
use App\Http\Requests\CreateVacationRequestRequest;
use App\Http\Requests\UpdateVacationRequestRequest;

class VacationRequestManagementController extends Controller {
    
    protected $vacationRequestRepository;

    public function __construct(IVacationRequestRepository $vacationRequestRepository) {
        $this->vacationRequestRepository = $vacationRequestRepository;
    }

    public function index() {
        $vacationRequests = $this->vacationRequestRepository->getVacationRequests();
        return view('vacationRequestManagement.index', ['vacationRequests' => $vacationRequests]);
    }

    public function show($id) {
        return;
    }

    public function create() {
        return view('vacationRequestManagement.create');
    }

    public function store(CreateVacationRequestRequest $request) {
        $validated = $request->validated();
        $this->vacationRequestRepository->createVacationRequest($request);
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
}
