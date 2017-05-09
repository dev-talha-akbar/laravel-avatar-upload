<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

use Auth;
use Image;

class AvatarController extends Controller
{
    public function __construct() {
        $this->middleware('auth', [
            'except' => 'fetchGiven'
        ]);
    }
    public function create()
    {
        return  view('avatar.upload')
                ->with('user', Auth::user());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|max:2048'
        ]);

        $base       = public_path(env('AVATAR_UPLOAD_PATH', 'uploads/avatars'));
        $name       = str_random(30);
        $extension  = env('AVATAR_UPLOAD_EXTENSION', 'jpg');

        Image::make($request->file)
                ->fit(env('AVATAR_UPLOAD_SIZE', '180'))
                ->save("{$base}/{$name}.{$extension}");

        if(!Auth::user()->avatar)
        {
            Avatar::create([
                'name'      => $name,
                'user_id'   => Auth::user()->id
            ]);
        }
        else
        {
            $avatar = Auth::user()->avatar;

            unlink("{$base}/{$avatar->name}.{$extension}");

            $avatar->name = $name;
            $avatar->save();
        }

        return  redirect()
                ->back()
                ->with('success', true);
    }
    public function fetch($size)
    {
        return $this->fetchGiven(Auth::user()->id, $size);
    }
    public function fetchGiven($id, $size)
    {
        $user = User::findOrFail($id);

        if($user->avatar)
        {
            $base       = public_path(env('AVATAR_UPLOAD_PATH', 'uploads/avatars'));
            $name       = $user->avatar->name;
            $extension  = 'jpg';

            $url        = "{$base}/{$name}.{$extension}";

            $image      = Image::make($url)
                                ->fit($size);
        }
        else if(env('AVATAR_DEFAULT_PATH', false) != false)
        {
            $url    = public_path(env('AVATAR_DEFAULT_PATH'));

            $image  = Image::make($url)
                            ->fit($size);
        }
        else
        {
            $base       = 'http://www.gravatar.com/avatar';
            $name       = md5($user->email);
            $default    = env('GRAVATAR_DEFAULT', 'identicon');

            $url        = "{$base}/{$name}?s={$size}&d={$default}";

            $image      = Image::make($url);
        }

        return $image->response();
    }
}
