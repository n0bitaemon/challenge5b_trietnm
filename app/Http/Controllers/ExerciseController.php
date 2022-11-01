<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Exercise;
use App\Models\User;

class ExerciseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $exercises = Exercise::all();

        return view('exercises.list', ['exercises' => $exercises]);
    }

    public function detail($id){
        $exercise = Exercise::find($id);
        $creator = User::find($exercise->creator_id);

        return view('exercises.detail', ['exercise'=>$exercise, 'creator'=>$creator]);
    }

    public function getAdd(Request $request){
        if($request->user()->cannot('access', Exercise::class)){
            abort(404);
        }
        return view('exercises.add');
    }

    public function postAdd(Request $request){
        if($request->user()->cannot('access', Exercise::class)){
            abort(404);
        }
        $validator = $request->validate([
            'title' => ['required', 'max:255'],
            'file' => ['required', File::types(['txt', 'docx'])],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time']
        ]);

        $uploadFileName = $request->file->getClientOriginalName();
        $storeFileName = floor(microtime(true) * 10000).'_'.$uploadFileName;
        $request->file->storeAs('private/exercises', $storeFileName);

        $exercise = new Exercise;
        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->file = $storeFileName;
        $exercise->creator_id = $request->user()->id;
        $exercise->start_time = $request->start_time;
        $exercise->end_time = $request->end_time;
        $exercise->is_published = $request->is_published === 'on' ? 1 : 0;

        $exercise->save();

        return redirect()->route('exercises.index');
    }

    public function getUpdate(Request $request, $id){
        if($request->user()->cannot('access', Exercise::class)){
            abort(404);
        }
        $exercise = Exercise::find($id);

        return view('exercises.update', ['exercise'=>$exercise]);
    }

    public function postUpdate(Request $request){
        if($request->user()->cannot('access', Exercise::class)){
            abort(404);
        }
        $validator = $request->validate([
            'title' => ['required', 'max:255'],
            'file' => [File::types(['txt', 'docx'])],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time']
        ]);

        $exercise = Exercise::find($request->id);
        if($request->hasFile('file')){
            //Delete old file
            Storage::delete('private/exercises/'.$request->file);

            //Upload new file
            $uploadFileName = $request->file('file')->getClientOriginalName();
            $newFileName = floor(microtime(true) * 10000).'_'.$uploadFileName;
            Storage::putFileAs('private/exercises', $request->file('file'), $newFileName);
            $exercise->file = $newFileName;
        }

        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->start_time = $request->start_time;
        $exercise->end_time = $request->end_time;
        $exercise->is_published = $request->is_published === 'on' ? 1 : 0;

        $exercise->save();

        return redirect()->route('exercises.detail', ['id'=>$request->id]);
    }

    public function delete(Request $request, $id){
        $exercise = Exercise::find($id);
        if($request->user()->cannot('access', Exercise::class)){
            abort(404);
        }
        Storage::delete('private/exercises/'.$exercise->file);
        $exercise->delete();
        
        return redirect()->route('exercises.index', ['id'=>$request->input('id')]);
    }

    public function download($id){
        $exercise = Exercise::find($id);
        return Storage::download('private/exercises/'.$exercise->file);
    }
}
