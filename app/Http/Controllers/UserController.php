<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Show a list of all users of the application.
     *
     * @return Response
     */
    public function index()
    {
//        $value = Cache::get('key');

        //
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProfile($id)
    {
        if(Cache::tags(['sessions', 'session_' . $id])->has('name'))
        {
            $userName = Cache::tags(['sessions', 'session_' . $id])->get('name');
            $userEmail = Cache::tags(['sessions', 'session_' . $id])->get('email');
        }else{
            $user = Auth::user();
            $userName = $user->name;
            $userEmail = $user->email;

            Cache::tags(['sessions', 'session_' . $user->id])->put('name', $user->name, 60);
            Cache::tags(['sessions', 'session_' . $user->id])->put('email', $user->email, 60);
        }

        return view('user.profile', ['userName' => $userName, 'userEmail' => $userEmail]);
    }

}
