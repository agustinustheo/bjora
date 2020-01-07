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
use Illuminate\Support\Facades\File;
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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::user()->id],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'birthday' => ['required', 'date'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

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
        $user->birthday = \DateTime::createFromFormat('Y-m-d', $user->birthday)->format('d/m/Y');
        return view('user.edit_profile', compact('user'));
    }

    protected function profile_view(Request $request)
    {
        $user = User::where('id', $request->segment(2))->first();
        return view('user.profile_view', compact('user'));
    }

    protected function edit_profile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $data = $request->all();
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $validation = $this->validator($data);
        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        } else {
            if ($request->hasFile('profile_picture')) {
                File::delete($user->profile_picture);
                $file = $request->file('profile_picture');
                $filename = $data['email'] . '-' . time() . '-' . $file->getClientOriginalName();
                $file->storeAs('public/img/profile_picture', $filename);
                $data['profile_picture'] = 'storage/img/profile_picture/' . $filename;
                $user->profile_picture = $data['profile_picture'];
            }

            //overwrite old user data
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->gender = $data['gender'];
            $user->address = $data['address'];
            $user->birthday = $data['birthday'];
            $user->save();
        }
        $user = User::find(Auth::user()->id);
        return view('user.profile', compact('user'));
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
        foreach ($data_message as $key) {
            $index_sender = $key->value('sender_id');
            $key->user_name = User::where('id', 'Like', $key->value('sender_id'))->value('name');
            $key->profile_picture = User::where('id', 'Like', $key->value('sender_id'))->value('profile_picture');
        }

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
