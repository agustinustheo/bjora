<?php

namespace App\Http\Controllers\Auth;

use DB;
use Cookie;
use Redirect;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => [
            'logout',
        ]]);
    }

    protected function login(Request $request){
        $credentials = $request->only('email', 'password');
        $remember=False;
        if($request->only('remember')!=null) $remember=True;
        if(Auth::attempt($credentials, $remember)) {
            $user_data = User::where('email', $request->only('email'));
            if($remember) return redirect('/')->withCookie(cookie()->forever('user_cookie', $user_data->id));
            else return redirect('/')->withCookie(cookie('user_cookie', $user_data->value('id'), 120));
        }
        else{
            return Redirect::back();
        }
    }
    
    public function login_view(Request $request){
        if($request->hasCookie('user_cookie')){
            return Redirect::back();
        }
        return view('auth.login');
    }

    public function logout(Request $request){
        Cookie::queue(Cookie::forget('user_cookie'));
        Auth::logout();
        return redirect('/');
    }
}
