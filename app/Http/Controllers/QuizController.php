<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Quiz;
use App\Models\QuizAnswer;
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
        if($quiz === null){
            abort(404);
        }
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
        $request->validate([
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
        $quiz->hint = $request->hint;
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
        if($quiz === null){
            abort(404);
        }

        return view('quizzes.update', ['quiz'=>$quiz]);
    }

    public function postUpdate(Request $request){
        $quiz = Quiz::find($request->id);
        if($quiz === null){
            abort(404);
        }
        if($request->user()->cannot('access', Quiz::class)){
            abort(404);
        }

        $request->validate([
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
        $quiz->hint = $request->hint;
        $quiz->start_time = $request->start_time;
        $quiz->end_time = $request->end_time;
        $quiz->is_published = $request->is_published === 'on' ? 1 : 0;

        $quiz->save();

        return redirect()->route('quizzes.detail', ['id'=>$request->id]);
    }

    public function delete(Request $request, $id){
        $quiz = Quiz::find($id);
        if($quiz === null){
            abort(404);
        }
        if($request->user()->cannot('access', Quiz::class)){
            abort(404);
        }
        Storage::delete('private/quizzes/'.$quiz->file);
        $quiz->delete();
        
        return redirect()->route('quizzes.index', ['id'=>$request->input('id')]);
    }

    public function download($id){
        $quiz = Quiz::find($id);
        if($quiz === null){
            abort(404);
        }
        return Storage::download($quiz->getFilePath());
    }

    public function answer(Request $request){
        $quiz = Quiz::find($request->quiz_id);
        if($quiz === null){
            abort(404);
        }
        if($request->user()->cannot('answer', $quiz)){
            abort(403);
        }

        $request->validate([
            'answer' => ['required', 'max:255'],
            'quiz_id' => ['required']
        ]);

        $quizAnswer = new QuizAnswer;
        $quizAnswer->quiz_id = $request->quiz_id;
        $quizAnswer->user_id = $request->user()->id;
        $quizAnswer->answer = $request->answer;

        $quizAnswer->save();

        return redirect()->route('quizzes.detail', ['id'=>$request->quiz_id]);
    }
}
