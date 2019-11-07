<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class Admins extends Controller
{
    public function index()
    {
        return view('admin_home');
    }
    public function login(){
        return view('auth.admin_login');
    }

    public function login_post(){
        $remember = request()->has('remember')?true:false;
        if(Auth::guard('admin')->attempt(['email' => request('email'), 'password' => request('password')], $remember))
        {
            return redirect('admin');
        }else{
            return back();
        }
    }
    public function logout(){
        auth()->guard('admin')->logout();
        return redirect('admin/login');
    }
}
