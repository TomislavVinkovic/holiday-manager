<?php

namespace App\Http\Repositories\Users;

use App\Http\Requests\UserCreationRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Collection;
use App\Models\User;

interface UserRepositoryInterface {
    public function getUserById(int $id, array $with = []): User;
    public function getAllNonSuperUsers(): Collection;
    public function addVacationDays(int $days, ?int $user_id=null): void;
    public function getUsersWithNoTeam(array $with = []): Collection;
    public function getMaxId(): int;
    public function createUserWithRoles(UserCreationRequest $request): User;
    public function patchUser(UserUpdateRequest $request): void;
    public function destroyUserById(int $id): void;
}