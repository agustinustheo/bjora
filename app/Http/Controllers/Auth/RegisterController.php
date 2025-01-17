<?php

namespace App\Http\Controllers\Auth;

use DB;
use DateTime;
use Redirect;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // method to validate registration inputs
    protected function validator(Array $data)
    {
        // automatically returns validation errors
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'profile_picture' => ['required'],
            'birthday' => ['required', 'date'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // method to create user
    protected function create(Array $data)
    {
        // creates user using model
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 2,
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'address' => $data['address'],
            'profile_picture' => $data['profile_picture'],
            'birthday' => $data['birthday'],
        ]);
    }

    // method to registrater user
    protected function register(Request $request){
        $data = $request->all();
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $validation = $this->validator($data);
        // validate and redirect if failed
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            // get file from file input
            $file = $request->file('profile_picture');  
            // get filename
            $filename = $data['email'].'-'.time().'-'.$file->getClientOriginalName();
            // save file in storage
            $file->storeAs('public/img/profile_picture', $filename);
            $data['profile_picture'] = 'storage/img/profile_picture/'.$filename;
            // create data
            $user = $this->create($data);
            $credentials = $request->only('email', 'password');
            // save credentials
            if(Auth::attempt($credentials)) {
                $user_data = User::where('email', $request->only('email'));
                return redirect('/')->withCookie(cookie('user_cookie', $user_data->value('id'), 120));
            }
        }
    }

    // method to registration view
    public function register_view(Request $request){
        // checking cookie if cookie exists redirect to previous page
        if($request->hasCookie('user_cookie')){
            return Redirect::back();
        }
        // else redirect to registration view
        return view('auth.register');
    }
}
