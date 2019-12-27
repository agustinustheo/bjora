<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\User;
use App\Topic;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class QuestionController extends Controller
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
        $this->middleware('auth', ['except' => [
            'answer_view',
        ]]);
    }

    protected function questionValidator(Array $data)
    {
        return Validator::make($data, [
            'question' => ['required', 'string'],
        ]);
    }

    protected function answerValidator(Array $data)
    {
        return Validator::make($data, [
            'answer' => ['required', 'string'],
        ]);
    }

    protected function add(Request $request){
        $request = $request->all();
        $validation = $this->questionValidator($request);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            Question::create([
                'question' => $request['question'],
                'status' => 1,
                'topic_id' => $request['topic'],
                'user_id' => Auth::user()->id,
            ]);
            return redirect('/');
        }
    }

    protected function edit(Request $request){
        $data = $request->all();
        $validation = $this->questionValidator($data);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            Question::whereId($request->only('id'))->update([
                'question' => $data['question'],
                'topic_id' => $data['topic'],
            ]);
            return redirect('/');
        }
    }

    protected function toggle_status(Request $request){
        $question = Question::find($request->segment(3));
        $update=1;
        if($question->status==1) $update=0;
        Question::whereId($request->segment(3))->update([
            'status' => $update,
        ]);
        return Redirect::back();
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
        $data = Topic::all();
        return view('question.add')->with(['Topics'=>$data]);
    }
    
    protected function edit_view(Request $request){
        $data = Topic::all();
        $question_data = Question::where('id', $request->segment(3))->first();
        if(Auth::user()->role != 1 && Auth::user()->id != $question_data->user_id) return Redirect::back();
        return view('question.edit')->with(['Topics'=>$data, 'Question'=>$question_data]);
    }

    protected function answer_view(Request $request){
        $question_data = Question::where('id', $request->segment(2))->first();
        $question_data->user_name = User::where('id', $question_data->user_id)->value('name');
        $question_data->profile_picture = User::where('id', $question_data->user_id)->value('profile_picture');
        $question_data->topic_name = Topic::where('id', $question_data->topic_id)->value('name');
        $answer_data = Answer::where('question_id', $request->segment(2));
        $answer_data = $answer_data->get();
        if($answer_data->count()>0){
            foreach($answer_data as $value){
                $value->user_name = User::where('id', $value->user_id)->value('name');
                $value->profile_picture = User::where('id', $value->user_id)->value('profile_picture');
            }
        }
        return view('question.answer')->with([
            'Question'=> $question_data,
            'Answers'=> $answer_data,
        ]);
    }
    
    protected function edit_answer_view(Request $request){
        $answer_data = Answer::where('id', $request->segment(3))->first();
        return view('question.edit_answer')->with(['Answer'=>$answer_data]);
    }

    protected function add_answer(Request $request){
        $request = $request->all();
        $validation = $this->answerValidator($request);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            Answer::create([
                'answer' => $request['answer'],
                'question_id' => $request['question_id'],
                'user_id' => Auth::user()->id,
            ]);
        }
        return Redirect::back();
    }

    protected function edit_answer(Request $request){
        $data = $request->all();
        $validation = $this->answerValidator($data);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            Answer::whereId($request->only('id'))->update([
                'answer' => $data['answer'],
            ]);
            $question_id = Answer::where('id', $request->only('id'))->value('question_id');
            return redirect("/answer/".$question_id);
        }
    }

    protected function delete_answer(Request $request){
        $answer = Answer::find($request->segment(3));
        $answer->delete();
        return Redirect::back();
    }
}
