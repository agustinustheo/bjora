<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\Answer;
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

    protected function edit(Request $request){
        $data = $request->all();
        Question::whereId($request->only('id'))->update([
            'question' => $data['question'],
            'topic_id' => $data['topic'],
        ]);
        return redirect('/');
    }

    protected function toggle_status(Request $request){
        $question = Question::find($request->segment(3));
        $update=1;
        if($question->status==1) $update=0;
        Question::whereId($request->only('id'))->update([
            'status' => $update,
        ]);
        return redirect('/');
    }

    protected function delete(Request $request){
        $question = Question::find($request->segment(3));
        $question->delete();
        return Redirect::back();
    }

    protected function question_view(){
        return view('question');
    }
    
    protected function add_view(){
        $data = DB::table('topics')->get();
        return view('question.add')->with(['Topics'=>$data]);
    }
    
    protected function edit_view(Request $request){
        $data = DB::table('topics')->get();
        $question_data = DB::table('questions')->where('id', $request->segment(3))->first();
        return view('question.edit')->with(['Topics'=>$data, 'Question'=>$question_data]);
    }
    
    protected function master_view(Request $request){
        return view('question.master');
    }

    protected function answer_view(Request $request){
        $question_data = DB::table('questions')->where('id', $request->segment(2))->first();
        $question_data->user_name = DB::table('users')->where('id', $question_data->user_id)->value('name');
        $question_data->profile_picture = DB::table('users')->where('id', $question_data->user_id)->value('profile_picture');
        $question_data->topic_name = DB::table('topics')->where('id', $question_data->topic_id)->value('name');
        $answer_data = DB::table('answers')->get();
        foreach($answer_data as $value){
            $value->user_name = DB::table('users')->where('id', $value->user_id)->value('name');
            $value->profile_picture = DB::table('users')->where('id', $value->user_id)->value('profile_picture');
        }
        return view('question.answer')->with([
            'Question'=> $question_data,
            'Answers'=> $answer_data,
        ]);
    }

    protected function add_answer(Request $request){
        $request = $request->all();
        Answer::create([
            'answer' => $request['answer'],
            'question_id' => $request['question_id'],
            'user_id' => session('user'),
        ]);
        return Redirect::back();
    }

    protected function delete_answer(Request $request){
        $answer = Answer::find($request->segment(3));
        $answer->delete();
        return Redirect::back();
    }
}