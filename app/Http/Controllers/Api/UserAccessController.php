<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccessResource;
use App\Models\Access;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAccessController extends Controller
{
    public function index($userId): JsonResource
    {
        $accesses = Access::query()
            ->where('user_id', $userId)
            ->with(['building'])
            ->paginateIf();

        return AccessResource::collection($accesses);
    }
}
