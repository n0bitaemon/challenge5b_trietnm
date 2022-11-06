<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use App\Models\ExerciseAnswer;
use App\Models\Exercise;

class ExerciseAnswerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){
        $exercise = Exercise::find($request->exercise_id);
        if($request->user()->cannot('answer', $exercise)){
            abort(403);
        }

        $request->validate([
            'file' => [File::types(['txt', 'docx'])]
        ]);

        $answer = ExerciseAnswer::where([
            ['user_id', '=', $request->user()->id],
            ['exercise_id', '=', $request->exercise_id]
        ])->first();

        if($answer === null){
            //Insert
            $answer = new ExerciseAnswer;
            $answer->user_id = $request->user()->id;
            $answer->exercise_id = $request->exercise_id;
            
            $uploadFileName = $request->file->getClientOriginalName();
            $storedFileName = floor(microtime(true) * 10000).'_'.$uploadFileName;
            $request->file->storeAs('private/exercises/answers', $storedFileName);

            $answer->answer_file = $storedFileName;
        }else{
            //Update
            if($request->hasFile('file')){
                //Delete old file
                Storage::delete('private/exercises/answers/'.$answer->answer_file);
    
                //Upload new file
                $uploadFileName = $request->file('file')->getClientOriginalName();
                $newFileName = floor(microtime(true) * 10000).'_'.$uploadFileName;
                Storage::putFileAs('private/exercises/answers', $request->file('file'), $newFileName);
                $answer->answer_file = $newFileName;
            }
        }
        $answer->is_done = true;

        $answer->save();

        return redirect()->route('exercises.detail', ['id'=>$request->exercise_id]);
    }
    
    public function cancle(Request $request, $id){
        $exercise = Exercise::find($id);
        if($exercise === null){
            abort(404);
        }
        if($request->user()->cannot('cancleAnswer', $exercise)){
            abort(403);
        }

        $answer = ExerciseAnswer::where([
            ['user_id', '=', $request->user()->id],
            ['exercise_id', '=', $id]
        ])->first();

        if($answer !== null){
            $answer->is_done = 0;
            $answer->save();
        }

        return redirect()->route('exercises.detail', ['id'=>$id]);
    }

    public function download(Request $request, $exercise_id, $user_id){
        $answer = ExerciseAnswer::where([
            ['user_id', '=', $user_id],
            ['exercise_id', '=', $exercise_id]
        ])->first(['answer_file']);
        if($answer === null){
            abort(404);
        }
        
        return Storage::download('private/exercises/answers/'.$answer->answer_file);
    }
}
