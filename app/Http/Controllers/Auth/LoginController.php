<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Config;
use Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

        protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $t = '';
        // if(Request::segment(1) == 'admin'){
        //     // $t = 
        //     Config::set('auth.defaults.guard','admin');
        // }else{
        //     // $t = 
        //     Config::set('auth.defaults.guard','web');
        // }
        // dd($t);
        $this->middleware('guest')->except('logout');
    }

    // public function direct(){
    //     $str ='';
    //     if(Request::segment(1) == 'admin'){
    //         $str = 'admin/home';
    //     }else{
    //         $str = '/home';
    //     }
    //     return $str;
    // }
}
