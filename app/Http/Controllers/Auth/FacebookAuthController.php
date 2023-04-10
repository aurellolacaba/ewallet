<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class FacebookAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleCallback()
    {
        $facebook = Socialite::driver('facebook')->user();
        
        $user = User::updateOrCreate([
            'facebook_id' => $facebook->id,
        ], [
            'name' => $facebook->name,
            'email' => $facebook->email,
        ]);

        $user->createWallet();
    
        Auth::login($user);
    
        return to_route('dashboard');
    }
}
