<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;

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
        return view('userManagement.create');
    }

    public function store(UserCreationRequest $request) {
        $validated = $request->validated();

        try {
            User::create([
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
            return redirect(route('userManagement'), 201);
        } catch(Exception $e) {
            throw $e;
        }
    }


    public function update($id) {
        if(!$id) {
            abort(404);
        }
        $user = User::find($id);
        if(!$user) {
            abort(404);
        }
        else {
            return view('userManagement.update', ['user' => $user]);
        }
    }

    public function patch(UserUpdateRequest $request) {
        $validated = $request->validated();

        try {
            User::where('id', $request->id)->update(
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