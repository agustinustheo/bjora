<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    //validator on admin side of add topic
    protected function validator(Array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string']
        ]);
    }

    //store all data into object of topic model
    protected function create(Array $data) {
        return Topic::create([
            'name' => $data['name']
        ]);
    }

    //get all topic and return to edit topic page
    public function getAllTopic() {
        $topics = Topic::paginate(10);

        return view('admin.topics', compact('topics'));
    }

    //show add topic blade
    public function showAddTopicForm() {
        return view('admin.add-topic');
    }

    //receive all inputs from form and add to topics table
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

    //show edit topic page
    public function showEditTopicForm($id) {
        $topic = Topic::find($id);

        return view('admin.edit-topic', compact('topic'));
    }

    //get topic id and all data from form
    //and update the data based on the topic data found by id
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

    //find topic id and delete the data
    //then return to the edit topic page
    public function deleteTopic($id) {
        $topic = Topic::find($id);
        $topic->delete();

        return redirect()->route('view-all-topic');
    }
}
