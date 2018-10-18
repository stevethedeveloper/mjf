<?php

namespace App\Http\Controllers;

use App\UserConsumed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsumedController extends Controller
{
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'drink_id' => 'required|integer',
            'servings_consumed' => 'required|integer',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $consumed = UserConsumed::create([
            'user_id' => $request->get('user_id'),
            'drink_id' => $request->get('drink_id'),
            'servings_consumed' => $request->get('servings_consumed'),
        ]);

        return response()->json(compact('consumed'),201);
    }
}
