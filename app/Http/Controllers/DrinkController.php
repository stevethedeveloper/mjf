<?php

namespace App\Http\Controllers;

use App\Drink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrinkController extends Controller
{
    /**
     * 
     * Add a favorite drink to the drinks lookup table
     * 
     */
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'servings' => 'required|integer|min:0',
            'caffeine_per_serving' => 'required|integer|min:0',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $drink = Drink::create([
            'name' => $request->get('name'),
            'servings' => $request->get('servings'),
            'caffeine_per_serving' => $request->get('caffeine_per_serving'),
        ]);

        return response()->json(compact('drink'),201);
    }
    
    /**
     * 
     * Return all drinks from the drinks table
     * 
     */
    public function getAllDrinks() {
        return Drink::orderBy('name')->get();
    }
    
}
