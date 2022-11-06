<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Message;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $users = User::all();
        return view('users.list', ['users'=>$users]);
    }

    public function profile(Request $request, $id = null){
        if($id === null){
            $user = $request->user();
        }else{
            $user = User::find($id);
            if($user === null){
                abort(404);
            }
        }

        return view('users.profile', ['user'=>$user]);
    }

    public function getAdd(Request $request){
        if($request->user()->cannot('add', User::class)){
            abort(404);
        }

        return view('users.add');
    }

    public function postAdd(Request $request){
        if($request->user()->cannot('add', User::class)){
            abort(404);
        }
        $request->validate([
            'fullname' => ['required', 'max:255'],
            'username' => ['required', 'min:8', 'max:255', 'unique:users'],
            'password' => ['required', 'max:255', 'confirmed', Password::min(8)],
            'email' => ['max:255', 'email'],
            'phone' => ['digits:10']
        ]);

        $user = new User;
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->save();
        
        return redirect()->route('users.index');
    }

    public function getUpdate(Request $request, $id = null){
        if($id !== null){
            $user = User::find($id);
            if($user === null){
                abort(404);
            }
        }else{
            $user = $request->user();
        }

        if($request->user()->cannot('update', $user)){
            abort(404);
        }

        return view('users.update', ['user'=>$user]);
        
    }

    public function postUpdate(Request $request){
        $user = User::find($request->id);
        if($user === null){
            abort(404);
        }
        if($request->user()->cannot('update', $user)){
            abort(404);
        }

        if($user->is_teacher){
            $request->validate([
                'fullname' => ['required', 'max:255'],
                'username' => ['required', 'min:8', 'max:255'],  Rule::unique('users')->ignore($user->id),
            ]);
        }

        $request->validate([
            'email' => ['max:255', 'email', 'nullable'],
            'file' => [File::image()],
            'phone' => ['max:10', 'digits:10', 'nullable'],
            'url_avatar' => ['nullable', function($attribute, $value, $fail){
                try{
                    if(getimagesize($value) == false){
                        $fail('URL không phải ình ảnh');
                    }
                }catch(Exception $e){
                    $fail('Lỗi khi xử lý hình ảnh');
                }
            }]
        ]);

        if($request->user()->is_teacher){
            $user->fullname = $request->fullname;
            $user->username = $request->username;
        }
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->hasFile('avatar')){
            //Upload new avatar
            $uploadFileName = $request->file('avatar')->getClientOriginalName();
            $newAvatar = floor(microtime(true) * 10000).'_'.$uploadFileName;
            Storage::disk('public_upload')->putFileAs('avatars', $request->file('avatar'), $newAvatar);

            //Delete old avatar
            Storage::disk('public_upload')->delete('avatars/'.$user->avatar);

            $user->avatar = $newAvatar;
        }else if($request->has('url_avatar')){
            $extension = image_type_to_extension(getimagesize($request->url_avatar)[2]);
            $uploadFileName = 'avatar'.$extension;
            $newAvatar = floor(microtime(true) * 10000).'_'.$uploadFileName;
            
            copy($request->url_avatar, public_path('avatars').'/'.$newAvatar);

            //Delete old avatar
            Storage::disk('public_upload')->delete('avatars/'.$user->avatar);

            $user->avatar = $newAvatar;
        }
        
        $user->save();
        
        return redirect()->route('users.profile', ['id'=>$user->id]);
    }

    public function getPassword(Request $request, $id = null){
        if($id !== null){
            $user = User::find($id);
            if($user === null){
                abort(404);
            }
        }else{
            $user = $request->user();
        }

        if($request->user()->cannot('update', $user)){
            abort(403);
        }

        return view('users.password', ['user'=>$user]);
    }

    public function postPassword(Request $request){
        $user = User::find($request->id);
        if($user === null){
            abort(404);
        }
        if($request->user()->cannot('update', $user)){
            abort(403);
        }

        if($request->user()->cannot('ignorePassword', $user)){
            $request->validate([
                'old_password' => ['required', 'current_password'],
                'new_password' => ['required', 'confirmed', 'min:8']
            ]);
        }else{
            $request->validate([
                'new_password' => ['required', 'confirmed', 'min:8']
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('users.profile', ['id'=>$user->id]);
    }

    public function delete(Request $request, $id){
        $user = User::find($id);
        if($user === 0){
            abort(404);
        }
        if($request->user()->cannot('delete', $user)){
            abort(404);
        }

        $user->delete();
        return redirect()->route('users.index');
    }
}
