<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    protected function validator(Array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string']
        ]);
    }

    protected function create(Array $data) {
        return Topic::create([
            'name' => $data['name']
        ]);
    }

    public function getAllTopic() {
        $topics = Topic::paginate(10);

        return view('admin.topics', compact('topics'));
    }

    public function showAddTopicForm() {
        return view('admin.add-topic');
    }

    public function addTopic(Request $request) {
        $data = $request->all();
        $validation = $this->validator($data);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }
        else{
            $user = $this->create($data);
            return redirect()->route('view-all-topic');
        }
    }

    public function showEditTopicForm($id) {
        $topic = Topic::find($id);

        return view('admin.edit-topic', compact('topic'));
    }

    public function editTopic(Request $request) {
        $topic = Topic::find($request->id);

        $data = $request->all();
        $validation = $this->validator($data);
        if($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        } else {
            $topic->name = $data['name'];
            $topic->save();

            return redirect()->route('view-all-topic');
        }
    }

    public function deleteTopic($id) {
        $topic = Topic::find($id);
        $topic->delete();

        return redirect()->route('view-all-topic');
    }
}
