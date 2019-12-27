<?php

namespace App\Http\Controllers\Admin;

use DB;
use Redirect;
use App\User;
use App\Topic;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    protected function master_view(Request $request){
        $question_data = Question::paginate(10);
        $topic_data = Topic::all();
        foreach($question_data as $value){
            $value->user_name = User::where('id', $value->user_id)->value('name');
            $value->topic_name = Topic::where('id', $value->topic_id)->value('name');
        }
        return view('admin.questions')->with([
            'Questions'=> $question_data,
        ]);
    }
}
