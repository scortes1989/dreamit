<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccessResource;
use App\Models\Access;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function store(Request $request): AccessResource
    {
        $request->merge(['user_id' => $request->user('api')->id]);

        $access = Access::create($request->only(['building_id', 'type', 'user_id']));

        return new AccessResource($access);
    }
}
