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
    // method to validate user update inputs
    protected function validator(array $data)
    {
        // automatically returns validation errors
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

    // method to validate message create inputs
    protected function messageValidator(array $data)
    {
        // automatically returns validation errors
        return Validator::make($data, [
            'message' => ['required', 'string'],
        ]);
    }

    // method to view user profile
    protected function view()
    {
        // get user data from auth
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // method to view user edit view
    protected function edit_profile_view()
    {
        // get user data from auth
        $user = Auth::user();
        // dd($user->birthday);
        // change date format
        $user->birthday = \DateTime::createFromFormat('Y-m-d', $user->birthday)->format('d/m/Y');
        return view('user.edit_profile', compact('user'));
    }

    // method to view profile view
    protected function profile_view(Request $request)
    {
        $user = User::where('id', $request->segment(2))->first();
        return view('user.profile_view', compact('user'));
    }

    // method to edit user profile
    protected function edit_profile(Request $request)
    {
        // get user data from database
        $user = User::find(Auth::user()->id);
        $data = $request->all();
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $validation = $this->validator($data);
        // validate and redirect if failed
        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        } else {
            if ($request->hasFile('profile_picture')) {
                // delete previous profile picture from storage
                File::delete($user->profile_picture);
                // get file from file input
                $file = $request->file('profile_picture');
                // get filename
                $filename = $data['email'] . '-' . time() . '-' . $file->getClientOriginalName();
                // save file in storage
                $file->storeAs('public/img/profile_picture', $filename);
                // set new profile picture data
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
        // get updated user
        $user = User::find(Auth::user()->id);
        return view('user.profile', compact('user'));
    }

    // method to send message to another user inbox
    protected function send_message(Request $request)
    {
        $request = $request->all();
        $validation = $this->messageValidator($request);
        // validate and redirect if failed
        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        } else {
            // send message by creating the message if validation succeeded
            Message::create([
                'sender_id' => $request['sender_id'],
                'receiver_id' => $request['receiver_id'],
                'message' => $request['message'],
            ]);
        }
        return Redirect::back();
    }

    // method to view user's inbox
    protected function inbox_view()
    {
        // get messages and paginate them 10 at a time
        $data_message = Message::where('receiver_id', Auth::user()->id)->paginate(10);
        foreach ($data_message as $key) {
            // get user name
            $key->user_name = User::where('id', $key->sender_id)->value('name');
            // get profile picture
            $key->profile_picture = User::where('id', $key->sender_id)->value('profile_picture');
        }

        return view('user.inbox', compact('data_message'));
    }
    
    // method  to delete message from inbox
    protected function delete_inbox(Request $request)
    {
        // get message by message id
        $message = Message::find($request->segment(3));
        // if the receiver is the authorized user
        if($message->receiver_id == Auth::user()->id){
            // delete the message
            $message->delete();
        }
        return Redirect::back();
    }
}
