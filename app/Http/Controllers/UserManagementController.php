<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Repositories\Users\UserRepositoryInterface;
use App\Models\Role;

class UserManagementController extends Controller
{

    public function __construct(protected UserRepositoryInterface $userRepository) {
        $this->middleware('auth');
        $this->middleware('superuser');
    }

    public function index() {
        $users = $this->userRepository->getAllNonSuperUsers();
        return view('userManagement.index', ['users' => $users]);
    }

    public function create() {
        $roles = Role::all(); //ubacitin role repository
        return view('userManagement.create', ['roles' => $roles]);
    }

    public function store(UserCreationRequest $request) {
        $validated = $request->validated();
        $this->userRepository->createUserWithRoles($request);
        return redirect(route('userManagement'), 201);
    }


    public function update($id) {
        if(!$id) {
            abort(404);
        }
        $roles = Role::all(); //ubaciti role repository
        $user = $this->userRepository->getUserById($id);

        return view('userManagement.update', ['user' => $user, 'roles' => $roles]);
    }

    public function patch(UserUpdateRequest $request) {
        $validated = $request->validated();
        $this->userRepository->patchUser($request);
        return redirect(route('userManagement'), 201);
    }

    public function destroy(Request $request) {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $this->userRepository->patchUser($request->id);
        return redirect(route('userManagement'), 201);
    }
}