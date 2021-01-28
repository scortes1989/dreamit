<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingStore;
use App\Http\Requests\BuildingUpdate;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BuildingController extends Controller
{
    public function index(): JsonResource
    {
        $buildings = Building::query()->orderBy('name')->paginateIf();

        return BuildingResource::collection($buildings);
    }

    public function show(Building $building): BuildingResource
    {
        return new BuildingResource($building);
    }

    public function store(BuildingStore $request): BuildingResource
    {
        $building = Building::create($request->only(['name', 'address']));

        return new BuildingResource($building);
    }

    public function update(BuildingUpdate $request, Building $building): BuildingResource
    {
        $building->update($request->only(['name', 'address']));

        return new BuildingResource($building);
    }

    public function destroy($buildingId): Response
    {
        Building::query()->where('id', $buildingId)->delete();

        return response([], 204);
    }
}
