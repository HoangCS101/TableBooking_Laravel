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
            $user = User::where('google_id', $provided_user->getId())->first();

            if (!$user) {
                $new = User::create([
                    'name' => $provided_user->getName(),
                    'email' => $provided_user->getEmail(),
                    'google_id' => $provided_user->getID()
                ]);
                Auth::login($new);
                return redirect('/booking');
            } else {
                Auth::login($user);
                return redirect('/booking');
            }
        }
        else if ($provider == 'facebook') {
            $user = User::where('facebook_id', $provided_user->getId())->first();

            if (!$user) {
                $new = User::create([
                    'name' => $provided_user->getName(),
                    'email' => $provided_user->getEmail(),
                    'facebook_id' => $provided_user->getID()
                ]);
                Auth::login($new);
                return redirect('/booking');
            } else {
                Auth::login($user);
                return redirect('/booking');
            }
        }
    }
}
