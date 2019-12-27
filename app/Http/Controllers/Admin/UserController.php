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

    public function getAllUser() {
        $users = User::paginate(10); 
        
        return view('admin.users', compact('users'));
    }

    public function showAddUserForm() {
        return view('admin.add-user');
    }

    public function addUser(Request $request) {
        $data = $request->all();
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $validation = $this->validator($data);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            $file = $request->file('profile_picture');  
            $filename = $data['email'].'-'.time().'-'.$file->getClientOriginalName();
            $file->storeAs('public/img/profile_picture', $filename);
            $data['profile_picture'] = 'storage/img/profile_picture/'.$filename;
            $user = $this->create($data);
            return redirect()->route('view-all-user');
        }
    }

    public function showEditUserForm($id) {
        $user = User::find($id);
        
        $user->birthday = Carbon::parse($user->birthday)->format('d/m/Y');

        return view('admin.edit-user', compact('user'));
    }

    public function editUser(Request $request) {
        $user = User::find($request->id);

        $data = $request->all();
        $data['email'] = sha1(time()).$data['email'];
        $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
        $validation = $this->editUserValidation($data);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        } else {
            $data['email'] = substr($data['email'],40);
            if($request->hasFile('profile_picture')){
                File::delete($user->profile_picture);
                $file = $request->file('profile_picture');  
                $filename = $data['email'].'-'.time().'-'.$file->getClientOriginalName();
                $file->storeAs('public/img/profile_picture', $filename);
                $data['profile_picture'] = 'storage/img/profile_picture/'.$filename;
            }
            else{
                $data['profile_picture'] = $user->value('profile_picture');
            }
            
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->role = $data['role'];
            $user->password = Hash::make($data['password']);
            $user->gender = $data['gender'];
            $user->address = $data['address'];
            $user->profile_picture = $data['profile_picture'];
            $user->birthday = $data['birthday'];
            $user->save();

            return redirect()->route('view-all-user');
        }
    }

    public function deleteUser($id) {
        $user = User::find($id);
        File::delete($user->profile_picture);
        $user->delete();

        return redirect()->route('view-all-user');
    }
}
