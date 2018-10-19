<?php

namespace App\Http\Controllers;

use App\UserConsumed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Traits\JWTCheck;

class ConsumedController extends Controller
{
    use JWTCheck;
    
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
    
    public function getConsumedForUser() {
        $user = $this->checkJwt();

        $user->consumed = UserConsumed::where([
            ['user_id', '=', $user->id],
            ['created_at', '>=', date('Y-m-d', mktime(0, 0, 0, date('n'), date('j'), date('Y')))],            
        ])->orderBy('created_at')
        ->with('Drink')
        ->get();
        
        $user = $user->toArray();
        
        $total_caffeine = 0;
        
        foreach ($user['consumed']->toArray() as $c) {
            $total_caffeine += $c['servings_consumed'] * $c['drink']['caffeine_per_serving'];
        }
        
        $user['consumed_total'] = $total_caffeine;
        
        return response()->json(compact('user'));
    }
}
