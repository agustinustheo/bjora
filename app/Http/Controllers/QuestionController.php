<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected function add(Request $request){
        $request = $request->all();
        Question::create([
            'question' => $request['question'],
            'status' => 1,
            'topic_id' => $request['topic'],
            'user_id' => session('user'),
        ]);
        return redirect('/');
    }

    public function question_view(){
        return view('question');
    }
    
    public function add_view(){
        $data = DB::table('topics')->get();
        return view('question.add')->with(['Topics'=>$data]);
    }
    
    public function edit_view(){
        $data = DB::table('topics')->get();
        return view('question.edit')->with(['Topics'=>$data]);
    }
}
