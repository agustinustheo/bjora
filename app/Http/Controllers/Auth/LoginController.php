<?php

namespace App\Http\Controllers\Auth;

use DB;
use Redirect;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;

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

    // method to do login
    protected function login(Request $request){
        $credentials = $request->only('email', 'password');
        $remember=False;
        // set remember me to true
        if($request->only('remember')!=null) $remember=True;
        if(Auth::attempt($credentials, $remember)) {
            $user_data = User::where('email', $request->only('email'))->first();
            if($remember) {
                //cookie is made to last for 2 hours
                //since the docx doesnt specify the duration
                //if you want to make it last forever, just remove the 3rd parameter
                $user_email = Cookie::make('user_email',$user_data->email,120);
                $user_password = Cookie::make('user_password',$user_data->password,120);
                $cookies = [$user_email, $user_password];
                return redirect('/')->withCookies($cookies);
            }

            else return redirect('/');
        }
        else{
            return Redirect::back();
        }
    }
    
    // method to show login view
    public function login_view(Request $request){
        if($request->hasCookie('user_email') && $request->hasCookie('user_password')){
            return Redirect::back();
        }
        return view('auth.login');
    }

    public function logout(Request $request){
        Auth::logout();

        //laboratory assistant's code
        // $response = \Response::make(redirect('/login'));
        // $response->cookie(\Cookie::forget('user_email'));
        // $response->cookie(\Cookie::forget('user_password'));
        // return $response;

        //cookie is removed when user clicks on another page
        //on assistant's code, the page is redirected 2 times,
        //1 to some kind of error page, and the second to the actual redirect
        //hence the cookie is removed on the final redirect
        $user_email = Cookie::forget('user_email');
        $user_password = Cookie::forget('user_password');
        $cookies = [$user_email, $user_password];
        return redirect('/login')->withCookies($cookies);
    }
}
