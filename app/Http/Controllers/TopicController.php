<?php

namespace App\Http\Controllers;

use Redirect;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    protected function add(Request $request){
        $request = $request->only('topic');
        Topic::create([
            'name' => $request['topic'],
        ]);
        return redirect('/');
    }

    public function topic_view(){
        return view('topic');
    }
    
    public function add_view(){
        return view('topic.add');
    }
    
    public function edit_view(){
        return view('topic.edit');
    }
}
