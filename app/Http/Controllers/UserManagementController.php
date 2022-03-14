<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\UserHasRole;

class UserManagementController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('superuser');
    }

    public function index() {
        $users = User::where('id', '<>', Auth::user()->id)->get();
        return view('userManagement.index', ['users' => $users]);
    }

    public function create() {
        $roles = Role::all();
        return view('userManagement.create', ['roles' => $roles]);
    }

    public function store(UserCreationRequest $request) {
        $validated = $request->validated();

        try {
            $user_id = User::insertGetId([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'oib' => $request->oib,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'residence' => $request->residence,
                'date_of_birth' => $request->date_of_birth,
                'is_superuser' => false,
                'available_vacation_days' => 20
            ]);

            foreach($request->roles as $role_id) {
                UserHasRole::create(
                    ['role_id' => $role_id, 'user_id' => $user_id],
                );//ovaj nacin mi se cinio najefikasniji za ovo
            }

            return redirect(route('userManagement'), 201);
        } catch(Exception $e) {
            throw $e;
        }
    }


    public function update($id) {
        if(!$id) {
            abort(404);
        }
        $roles = Role::all();
        $user = User::findOrFail($id);

        return view('userManagement.update', ['user' => $user, 'roles' => $roles]);
    }

    public function patch(UserUpdateRequest $request) {
        $validated = $request->validated();

        $user = User::findOrFail($request->id);

        try {
            $user->update(
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'oib' => $request->oib,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'residence' => $request->residence,
                    'date_of_birth' => $request->date_of_birth,
                ]
            );

            //obrisi sve role veze koji postoje, a nisu u novom requestu
            foreach($user->roles as $role) {
                if(!in_array($role->id, $request->roles)) {
                    UserHasRole::where([
                        'user_id' => $user->id,
                        'role_id' => $role->id
                    ])->firstOrFail()->delete();
                }
            }
            foreach($request->roles as $role_id) {
                UserHasRole::updateOrCreate(
                    ['role_id' => $role_id, 'user_id' => $request->id],
                    ['role_id' => $role_id, 'user_id' => $request->id]
                );//ovaj nacin mi se cinio najefikasniji za ovo
            }
            return redirect(route('userManagement'), 201);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);

            $id = $request->id;
            User::destroy($id);
            return redirect(route('userManagement', 201));
        } catch(Exception $e) {
            throw $e;
        }
    }
}