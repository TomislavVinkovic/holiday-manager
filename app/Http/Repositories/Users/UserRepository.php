<?php

namespace App\Http\Repositories\Users;

use App\Http\Repositories\Users\UserRepositoryInterface;
use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface {

    public function getUserById(int $id, array $with = []): User {
        return User::where('id', $id)->with($with)->firstOrFail();
    }

    public function getAllNonSuperUsers(): Collection {
        return User::where('id', '<>', Auth::user()->id)->get();
    }

    public function getUsersWithNoTeam(array $with = []): Collection {
        return User::where('is_superuser', false)->doesntHave('team')->with($with)->get();
    }

    public function getMaxId(): int {
        return User::max('id');
    }

    public function createUserWithRoles(UserCreationRequest $request): User {
        try {

            $user = User::create([
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

            $user->roles()->attach($request->roles);
            $user->save();

            return $user;

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function patchUser(UserUpdateRequest $request): void {

        try {
            $user = $this->getUserById($request->id);
            $requestData =  [
                'username' => $request->username,
                'email' => $request->email,
                'oib' => $request->oib,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'residence' => $request->residence,
                'date_of_birth' => $request->date_of_birth,
            ];
            $user->fill($requestData);
            if($user->isDirty()) {
                $user->update();
            }

            //delete all roles that are saved, but not in the new request
            foreach($user->roles as $role) {
                if(!in_array($role->id, $request->roles)) {
                    $user->roles()->detach($role->id);
                }
            }

            //add all the new roles
            $user->roles()->attach($request->roles);
            $user->save();

        } catch (Exception $e) {
            throw $e;
        }

        
    }

    public function destroyUserById(int $id): void {
        try {
            $user = $this->getUserById($id);
            $user->roles()->detach();
            $user->delete();
            
        } catch(Exception $e) {
            throw $e;
        }
    }
}