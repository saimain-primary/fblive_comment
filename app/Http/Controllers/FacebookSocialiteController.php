<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookSocialiteController extends Controller
{
    public function redirectToFB(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleCallback(Request $request)
    {
        Log::info('callback from facebook');
        Log::debug($request->all());
        try {
            $user = Socialite::driver('facebook')->user();
            $findUser = User::where('social_id', $user->id)->first();
            if($findUser) {
                Auth::login($findUser);
                return redirect('/home');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'facebook',
                    'password' => encrypt('my-facebook')
                ]);

                Auth::login($newUser);
                return redirect('/home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
