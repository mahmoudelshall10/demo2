<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\AdminPasswordResetRequest;
use App\Notifications\AdminPasswordResetSuccess;
use App\User;
use App\Admin;
use App\PasswordReset;

class AdminPasswordResetController extends Controller
{
     /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin)
            return response()->json([
                'message' => 'We can\'t find a admin with that e-mail address.'
            ], 404);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $admin->email],
            [
                'email' => $admin->email,
                'token' => str_random(60)
             ]
        );
        if ($admin && $passwordReset)
            $admin->notify(
                new AdminPasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        return response()->json($passwordReset);
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $admin = Admin::where('email', $passwordReset->email)->first();
        if (!$admin)
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);
        $admin->password = bcrypt($request->password);
        $admin->save();
        $passwordReset->delete();
        $admin->notify(new AdminPasswordResetSuccess($passwordReset));
        return response()->json($admin);
    }
}
