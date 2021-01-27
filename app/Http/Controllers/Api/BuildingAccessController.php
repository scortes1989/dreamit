<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccessResource;
use App\Models\Access;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingAccessController extends Controller
{
    public function index($buildingId): JsonResource
    {
        $accesses = Access::query()
            ->where('building_id', $buildingId)
            ->with(['user'])
            ->paginateIf();

        return AccessResource::collection($accesses);
    }
}
