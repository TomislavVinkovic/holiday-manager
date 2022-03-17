<?php

namespace App\Http\Repositories\Users;

use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

interface IUserRepository {
    public function createUserWithRoles(UserCreationRequest $request): User;
    public function patchUser(UserUpdateRequest $request): void;
    public function destroyUserById(int $id): void;
}