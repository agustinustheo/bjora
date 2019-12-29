<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    //validator on admin side of add user
    protected function validator(Array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'profile_picture' => ['required'],
            'birthday' => ['required', 'date'],
        ]);
    }

    //validator on admin side of edit user
    protected function editUserValidation(Array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'birthday' => ['required', 'date'],
        ]);
    }

    //store all data into object of user model
    protected function create(Array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'address' => $data['address'],
            'profile_picture' => $data['profile_picture'],
            'birthday' => $data['birthday'],
        ]);
    }

    //get all user data and paginate it by tens
    public function getAllUser() {
        $users = User::paginate(10); 
        
        //then return the data to be shown in the manage user page
        return view('admin.users', compact('users'));
    }

    //return to blade of add user form page
    public function showAddUserForm() {
        return view('admin.add-user');
    }

    //method to add user
    public function addUser(Request $request) {
        //store all request data to data array
        $data = $request->all();
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $validation = $this->validator($data);
        //if validator fails, return back to add user form with the error message
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            //manage profile picture file name and store location
            $file = $request->file('profile_picture');  
            $filename = $data['email'].'-'.time().'-'.$file->getClientOriginalName();
            $file->storeAs('public/img/profile_picture', $filename);
            $data['profile_picture'] = 'storage/img/profile_picture/'.$filename;
            //store all user data
            $user = $this->create($data);
            //redirect back to manage user page
            return redirect()->route('view-all-user');
        }
    }

    //method to show edit user form
    public function showEditUserForm($id) {
        //find user that wants to be edited by his/her id
        $user = User::find($id);
        
        //format the date time by converting it into Carbon object then formatting it
        $user->birthday = Carbon::parse($user->birthday)->format('d/m/Y');

        //send the user data to edit user form
        return view('admin.edit-user', compact('user'));
    }

    //method to edit the user
    public function editUser(Request $request) {
        //the same method ass addUser wont be commented again
        $user = User::find($request->id);

        $data = $request->all();
        //bypass validator on unique email, since the old user email is not removed yet
        //new email is appended by an encryption of current time
        //so the encryption will always be different
        $data['email'] = sha1(time()).$data['email'];
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $validation = $this->editUserValidation($data);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        } else {
            //remove the unique hash encryption
            $data['email'] = substr($data['email'],40);
            if($request->hasFile('profile_picture')){
                File::delete($user->profile_picture);
                $file = $request->file('profile_picture');  
                $filename = $data['email'].'-'.time().'-'.$file->getClientOriginalName();
                $file->storeAs('public/img/profile_picture', $filename);
                $data['profile_picture'] = 'storage/img/profile_picture/'.$filename;
            }
            else{
                $data['profile_picture'] = $user->profile_picture;
            }
            
            //overwrite old user data
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->role = $data['role'];
            $user->password = Hash::make($data['password']);
            $user->gender = $data['gender'];
            $user->address = $data['address'];
            $user->profile_picture = $data['profile_picture'];
            $user->birthday = $data['birthday'];
            $user->save();

            //redirect to manage user page
            return redirect()->route('view-all-user');
        }
    }

    //method to delete user
    public function deleteUser($id) {
        //find user data that wants to be deleted by id
        $user = User::find($id);
        //remove user profile picture from storage
        File::delete($user->profile_picture);
        //remove user data from database
        $user->delete();

        //redirect to manage user page
        return redirect()->route('view-all-user');
    }
}
