<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): JsonResource
    {
        $users = User::query()->orderBy('name')->paginateIf();

        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store(UserStore $request): UserResource
    {
        $user = User::create($request->only(['name', 'email', 'password']));

        return new UserResource($user);
    }

    public function update(UserUpdate $request, User $user): UserResource
    {
        $user->update($request->only(['name', 'email', 'password']));

        return new UserResource($user);
    }

    public function destroy($userId): Response
    {
        User::query()->where('id', $userId)->delete();

        return response([], 204);
    }
}
