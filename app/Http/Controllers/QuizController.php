<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Quiz;
use App\Models\User;

class QuizController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $quizzes = Quiz::all();

        return view('quizzes.list', ['quizzes' => $quizzes]);
    }

    public function detail($id){
        $quiz = Quiz::where('id', '=', $id)->first();
        $creator = User::where('id', '=', $quiz->creator_id)->first();

        return view('quizzes.detail', ['quiz'=>$quiz, 'creator'=>$creator]);
    }

    public function getAdd(Request $request){
        if($request->user()->cannot('access', Quiz::class)){
            abort(404);
        }

        return view('quizzes.add');
    }

    public function postAdd(Request $request){
        if($request->user()->cannot('access', Quiz::class)){
            abort(404);
        }
        $validator = $request->validate([
            'title' => ['required', 'max:255'],
            'file' => ['required', File::types(['txt']), function($attribute, $value, $fail) use ($request){
                $uploadFileName = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
                if(!preg_match('/^[a-z_]+$/', $uploadFileName)){
                    $fail('File name must contains only lowercase characters and underscores');
                }
            }],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time']
        ]);

        $uploadFileName = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
        $storeFileName = floor(microtime(true) * 10000).'_'.$uploadFileName;
        $request->file->storeAs('private/quizzes', $storeFileName);

        $quiz = new Quiz;
        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->file = $storeFileName;
        $quiz->creator_id = $request->user()->id;
        $quiz->start_time = $request->start_time;
        $quiz->end_time = $request->end_time;
        $quiz->is_published = $request->is_published === 'on' ? 1 : 0;

        $quiz->save();

        return redirect()->route('quizzes.index');
    }

    public function getUpdate(Request $request, $id){
        if($request->user()->cannot('access', Quiz::class)){
            abort(404);
        }

        $quiz = Quiz::find($id);
        return view('quizzes.update', ['quiz'=>$quiz]);
    }

    public function postUpdate(Request $request){
        if($request->user()->cannot('access', Quiz::class)){
            abort(404);
        }

        $validator = $request->validate([
            'title' => ['required', 'max:255'],
            'file' => [File::types(['txt']), function($attribute, $value, $fail) use ($request){
                $uploadFileName = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
                if(!preg_match('/^[a-z_]+$/', $uploadFileName)){
                    $fail('File name must contains only lowercase characters and underscores');
                }
            }],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time']
        ]);

        $quiz = Quiz::find($request->id);
        if($request->hasFile('file')){
            //Delete old file
            Storage::delete('private/quizzes/'.$request->file);

            //Upload new file
            $uploadFileName = $request->file('file')->getClientOriginalName();
            $newFileName = floor(microtime(true) * 10000).'_'.$uploadFileName;
            Storage::putFileAs('private/quizzes', $request->file('file'), $newFileName);
            $quiz->file = $newFileName;
        }

        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->start_time = $request->start_time;
        $quiz->end_time = $request->end_time;
        $quiz->is_published = $request->is_published === 'on' ? 1 : 0;

        $quiz->save();

        return redirect()->route('quizzes.detail', ['id'=>$request->id]);
    }

    public function delete(Request $request, $id){
        $quiz = Quiz::find($id);
        if($request->user()->cannot('access', Quiz::class)){
            abort(404);
        }
        Storage::delete('private/quizzes/'.$quiz->file);
        $quiz->delete();
        
        return redirect()->route('quizzes.index', ['id'=>$request->input('id')]);
    }

    public function download($id){
        $quiz = Quiz::find($id);
        return Storage::download('private/quizzes/'.$quiz->file);
    }
}