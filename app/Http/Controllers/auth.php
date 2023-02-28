<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Two\InvalidStateException;

class auth extends Controller
{
    public function index(Request $request)
    {

        if (FacadesAuth::check()) {
            return redirect()->route("index");
        }
        return view("auth.login-form", array());
    }
    public function logout(Request $request)
    {
        if (FacadesAuth::check()) {
            session()->flush();
            return redirect()->route("index");
        }

        return view("auth.login-form", array());
    }
    public function loginRedirect(Request $request)
    {
        return Socialite::driver("google")->redirect();
    }
    public function loginCallback(Request $request)
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            $statusMessage = "S'ha produit un error a l'hora d'iniciar sessio. Prova un altre cop.";
            return view("auth.login-form", compact("statusMessage"));
            // return redirect()->route("login");
        }

        $user = User::where('email', $socialUser->email)->first();
        if (is_null($user)) {
            $statusMessage = "Has iniciat sessió correctament, però no tens accés a aquest pagina. Si creus que aixo es un error, contacta amb l'administrador.";
            // return view("auth.login-form", compact("statusMessage"));
            return \redirect()->route("login")->with("statusMessage", $statusMessage);
        }

        // FacadesAuth::loginUsingId($user->id);
        FacadesAuth::login($user);
        return redirect()->route("index");
    }
}
