<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LockResource;
use App\Models\Lock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class LockController extends Controller
{
    public function index(): JsonResource
    {
        $locks = Lock::query()
            ->with(['user', 'building'])
            ->paginateIf();

        return LockResource::collection($locks);
    }

    public function store(Request $request): LockResource
    {
        $lock = Lock::create($request->only(['building_id', 'user_id']));

        return new LockResource($lock);
    }

    public function destroy($lockId): Response
    {
        Lock::query()->where('id', $lockId)->delete();

        return response([], 204);
    }
}
