<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfirmationController extends BaseController
{
    public function verify($code)
    {
        $user = User::where('confirmation_code', $code)->first();
        if ($user) {
            $user->email_confirmed = 1;
            $user->email_verified_at = now();
            $user->confirmation_code = null;
            $user->save();
            Auth::login($user);
            return view('dashboard', ['user' => $user]);
        } else {
            return view('code-error');
        }
    }
}
