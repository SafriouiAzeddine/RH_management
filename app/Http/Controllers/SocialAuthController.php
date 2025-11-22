<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Rechercher l'utilisateur dans la base de données par e-mail
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Mettre à jour le google_id si nécessaire
                if (is_null($user->google_id)) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }

                // Connecter l'utilisateur
                Auth::login($user);

                // Rediriger vers la page d'accueil ou autre
                return redirect()->to('/fonctionnaire/dashboard');
            } else {
                Session::flash('error', 'Vous devez d\'abord être enregistré dans notre système.');
                return redirect()->to('/login');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Une erreur est survenue lors de l\'authentification avec Google.');
            return redirect()->to('/login');
        }
    }
}
