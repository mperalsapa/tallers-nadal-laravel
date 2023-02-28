<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class index extends Controller
{
    public function index()
    {
        // manual user seek
        // $userId = session()->get('id');
        // $user = User::find($userId);
        // $user->touch();

        // dd(Auth::user());
        // echo "hola " . Auth::user()->name;
        // echo "Hola " . $user->name . ". Tens rol de: " . $user->role->name;
        return view("user.index", array());
    }

    public function index1()
    {
        return "hola user";
    }
    public function index2()
    {
        // return 
        return "hola admin :D";
    }
}
