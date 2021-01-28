<?php

namespace App\Http\Requests;

use App\Rules\BuildingAccessRule;
use Illuminate\Foundation\Http\FormRequest;

class AccessStore extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'building_id' => new BuildingAccessRule()
        ];
    }
}
