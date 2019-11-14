<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
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
        $data = DB::table('topics')->where('id', $request->segment(3))->first();
        return view('topic.edit')->with('Topic', $data);
    }
}
