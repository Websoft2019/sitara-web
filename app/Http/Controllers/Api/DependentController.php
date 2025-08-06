<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dependent;
use App\Http\Resources\DependentResource;

class DependentController extends Controller
{
    public function getMyDependent() {
        return response()->json([
            'dependents' => DependentResource::collection(Dependent::where('employee_id', auth()->user()->id)->where('status', 'active')->get())
        ]);
    }
}
