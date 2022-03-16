<?php

namespace App\Http\Repositories\Users;

use App\Http\Repositories\Users\IUserRepository;
use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserRepository implements IUserRepository {

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
            $user = User::findOrFail($request->id);
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
                    $user->roles()->detach($role->id);
                }
            }

            $user->roles()->attach($request->roles);
            $user->save();

        } catch (Exception $e) {
            throw $e;
        }

        
    }

    public function destroyUserById(int $id): void {
        try {
            $user = User::findOrFail($id);
            $user->roles()->detach();
            $user->delete();
            
        } catch(Exception $e) {
            throw $e;
        }
    }
}