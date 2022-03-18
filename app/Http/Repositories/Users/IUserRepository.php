<?php

namespace App\Http\Repositories\Users;

use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Collection;
use App\Models\User;

interface IUserRepository {
    public function getUserById(int $id, array $with = []): User;
    public function getAllNonSuperUsers(): Collection;
    public function getUsersWithNoTeam(array $with = []): Collection;
    public function getMaxId(): int;
    public function createUserWithRoles(UserCreationRequest $request): User;
    public function patchUser(UserUpdateRequest $request): void;
    public function destroyUserById(int $id): void;
}