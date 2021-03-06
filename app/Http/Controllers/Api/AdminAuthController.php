<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Notifications\AdminsignupActivate;
use Avatar;
use Storage;

class AdminAuthController extends Controller
{
    /**
     * Create Admin
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:admins',
            'password' => 'required|string|confirmed',
            
        ]);
        $admin = new Admin([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activation_token' => str_random(60)
        ]);

        $admin->save();

        $avatar = Avatar::create($admin->name)->getImageObject()->encode('png');
        Storage::put('avatars/'.$admin->id.'/avatar.png', (string) $avatar);

        $admin->notify(new AdminsignupActivate($admin));

        return response()->json([
            'message' => 'Successfully created admin!'
        ], 201);
    }
  
    /**
     * Login Admin and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */


public function login(Request $request)
{
	$request->validate([
		'email' => 'required|string|email',
		'password' => 'required|string',
		'remember_me' => 'boolean'
		]);
    $credentials = request(['email', 'password']);

    $credentials['active'] = 1;
    $credentials['deleted_at'] = null;

    if(Auth::guard('admin')->attempt($credentials)){
        $user = Auth::guard('admin')->user();
        $success['token'] =  $user->createToken('admin')->accessToken;
        return response()->json(['Success' => $success , 'message' => 'Successfully Admin Login!']);
    }else{
        return response()->json(['error'=>'Unauthorised'], 401);
    }
}
    /**
     * Logout Admin (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        Auth::guard('admin-api')->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully admin logged out'
        ]);
    }
  
    /**
     * Get the authenticated Admin
     *
     * @return [json] Admin object
     */
    public function admin()
    {
     $user = Auth::guard('admin-api')->user();
  		  return response()->json(['success' => $user]);
    }

    public function signupActivate($token)
{
    $admin = Admin::where('activation_token', $token)->first();
    if (!$admin) {
        return response()->json([
            'message' => 'This activation token is invalid.'
        ], 404);
    }
    $admin->active = true;
    $admin->activation_token = '';
    $admin->save();
    return $admin;
}
}