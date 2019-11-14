<?php

namespace App\Http\Controllers;

use DB;
use App\Question;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $question_data = Question::paginate(10);
        $topic_data = DB::table('topics')->get();
        foreach($question_data as $value){
            $value->user_name = DB::table('users')->where('id', $value->user_id)->value('name');
            $value->profile_picture = DB::table('users')->where('id', $value->user_id)->value('profile_picture');
            $value->topic_name = DB::table('topics')->where('id', $value->topic_id)->value('name');
        }
        return view('home')->with([
            'Questions'=> $question_data,
        ]);
    }

    public function search(Request $request){
        $user_id_for_query = DB::table('users')->where('name', 'like', '%'.$request->get("query").'%')->value('id');
        $question_data = DB::table('questions')
                    ->where('question', 'like', '%'.$request->get("query").'%')
                    ->orWhere('user_id', $user_id_for_query)->paginate(10);
        $topic_data = DB::table('topics')->get();
        foreach($question_data as $value){
            $value->user_name = DB::table('users')->where('id', $value->user_id)->value('name');
            $value->profile_picture = DB::table('users')->where('id', $value->user_id)->value('profile_picture');
            $value->topic_name = DB::table('topics')->where('id', $value->topic_id)->value('name');
        }
        return view('home')->with([
            'Questions'=> $question_data,
        ]);
    }
}
