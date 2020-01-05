<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\User;
use App\Topic;
use App\Message;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class UserController extends Controller
{
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
        $this->middleware('auth', ['except' => [
            'answer_view',
        ]]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $users = Auth::user();
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users' . $users->id],
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
    protected function create(array $data)
    {
        return User::where('id', 'LIKE', Auth::user()->id)->updateOrCreate([
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

    protected function messageValidator(array $data)
    {
        return Validator::make($data, [
            'message' => ['required', 'string'],
        ]);
    }



    protected function view()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    protected function edit_profile_view()
    {
        $user = Auth::user();
        echo $user;
        return view('user.edit_profile', compact('user'));
    }

    protected function profile_view(Request $request)
    {
        $user = User::where('id', $request->segment(2))->first();
        return view('user.profile_view', compact('user'));
    }

    protected function edit_profile(Request $request)
    {

        $user = User::find(auth::user()->id);
        $data = $request->all();

        // echo $user;
        // dd($user);
        // dd($request);
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        // $validation = $this->validator($data);
        // if ($validation->fails()) {
        //     return Redirect::back()->withErrors($validation);
        // } else {
        $file = $request->file('profile_picture');
        $filename = $data['email'] . '-' . time() . '-' . $file->getClientOriginalName();
        $file->storeAs('public/img/profile_picture', $filename);
        $data['profile_picture'] = 'storage/img/profile_picture/' . $filename;
        $user = $this->create($data);
        //$credentials = $request->only('email', 'password');
        // }
    }


    protected function send_message(Request $request)
    {
        $request = $request->all();
        $validation = $this->messageValidator($request);
        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        } else {
            Message::create([
                'sender_id' => $request['sender_id'],
                'receiver_id' => $request['receiver_id'],
                'message' => $request['message'],
            ]);
        }
        return Redirect::back();
    }

    protected function inbox_view()
    {
        $data_message = Message::where('receiver_id', 'Like', Auth::user()->id)->get();
        // $index_sender = $data_message->sender_id;
        // $data_message->sender_name = User::where('id', 'Like', $data_message->sender_id)->value('name');
        // $sender_profile_picture = User::where('id', 'Like', $data_message->sender_id)->value('profile_picture');
        // $data_mesage =


        return view('user.inbox', compact('data_message'));
    }

    protected function myquestion_view()
    {
        $question_data = Question::where('user_id', Auth::user()->id);
        $user = Auth::user();


        echo $question_data;
        return view('user.myquestion_view');
    }
}
// , compact('question_data', 'user')
