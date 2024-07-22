<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        $provided_user = Socialite::driver($provider)->user();

        if ($provider == 'google') {
            $user = User::where('google_id', $provided_user->getID())->first();

            if (!$user) {
                // If not found, attempt to find by email
                $user = User::where('email', $provided_user->getEmail())->first();
            }

            if (!$user) {
                // If still not found, create a new user
                $user = User::create([
                    'name' => $provided_user->getName(),
                    'email' => $provided_user->getEmail(),
                ]);
            }
            
            $user->google_id = $provided_user->getID();
            $user->update();
        }
        else if ($provider == 'facebook') {
            $user = User::where('facebook_id', $provided_user->getId())->first();

            if (!$user) {
                // If not found, attempt to find by email
                $user = User::where('email', $provided_user->getEmail())->first();
            }

            if (!$user) {
                $user = User::create([
                    'name' => $provided_user->getName(),
                    'email' => $provided_user->getEmail(),
                ]);
            }

            $user->facebook_id = $provided_user->getID();
            $user->update();
        }
        
        Auth::login($user);
        return redirect('/booking');
    }
}
