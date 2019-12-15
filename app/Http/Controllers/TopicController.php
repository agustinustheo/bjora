<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class TopicController extends Controller
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
        $this->middleware('auth');
    }

    protected function add(Request $request){
        Topic::create($request->only('name'));
        return redirect('/');
    }
    
    protected function edit(Request $request){
        Topic::whereId($request->only('id'))->update($request->only('name'));
        return redirect('/');
    }

    public function topic_view(){
        return view('topic');
    }
    
    public function add_view(){
        return view('topic.add');
    }
    
    public function edit_view(Request $request){
        $data = Topic::where('id', $request->segment(3))->first();
        return view('topic.edit')->with('Topic', $data);
    }
}
