<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
class ProfileController extends Controller
{

// public function __construct()
// {
//     $this->middleware('auth');
// }

public function togglefollow(Request $request)
{
    $user = User::find(request('user_id'));
        // dd(Auth::guard('api')->user());
    $data = auth()->user()->toggleFollow($user);
    foreach($data as $k => $v)
    {
        foreach ($v as $key => $value) 
        {
	        if($user->id == $value)
	        {
	        	return response()->json(['error'=>'You Can\'t Follow or Unfollow Yourself']);
	        }
        }
    }
    return response()->json(['success'=>$data]);        
}

public function togglelike(Request $request)
{
    $user = User::find(request('user_id'));
    // dd($request->user());
    // dd(Auth::guard('api'));
    // dd($user);
    // dd($request->user('api'));
    // dd(auth('api')->user());
    // dd(Auth::user());
    dd(auth()->user());

    $response = auth()->user()->toggleLike($user);
    foreach($response as $k => $v)
    {
        foreach ($v as $key => $value) 
        {
            if($user->id == $value)
            {
                return response()->json(['error'=>'You Can\'t Like or DisLike Yourself']);
            }
        }
    }

    return response()->json(['success'=> $response]);
}

}
