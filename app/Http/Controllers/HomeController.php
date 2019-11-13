<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $question_data = DB::table('questions')->get();
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
